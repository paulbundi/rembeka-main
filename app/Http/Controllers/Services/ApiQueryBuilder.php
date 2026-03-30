<?php

namespace App\Http\Controllers\Services;

use Illuminate\Database\Eloquent\Builder;
use InvalidArgumentException;

/**
 * An HTTP layer service to build an eloquent database query builder object from a GET request
 * for a collection of items
 */
class ApiQueryBuilder
{
    /**
     * Get multiple models for api requests
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array                                 $ids
     * @param int|null                              $page
     * @param int                                   $perPage
     * @param array                                 $filters
     * @param array                                 $order
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function buildFilteredQuery($query, ApiRequestFilter $filter)
    {
        $ids = $filter->getIds();
        $order = $filter->getOrder();

        if (head($ids) !== '*') {
            $query->whereKey($ids);
        }

        $this->applyFilters($query, $filter->getFilters());
        $this->applyHasFilters($query, $filter->getHas());
        $this->applyIncludes($query, $filter->getIncludes());

        if (! empty($order)) {
            foreach ($order as $field) {
                $query->orderBy($field[0], $field[1]);
            }
        }

        return $query;
    }

    /**
     * Applies the given filters to the query. The filters needs to be an array of arrays, which have the first
     * value as the field name, the second value as the operator, and the third as the value to match
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array                                 $filters
     **/
    protected function applyFilters($query, array $filters = [])
    {
        if (empty($filters)) {
            return;
        }

        foreach ($filters as $filter) {
            if (is_array($filter[0])) {
                $constraint = 'where';
                if (last($filter) === 'or') {
                    $constraint = 'orWhere';
                    array_pop($filter);
                }

                $query->{$constraint}(function ($q) use ($filter) {
                    foreach ($filter as $subFilter) {
                        $this->applyMultiFilters($q, $subFilter);
                    }
                });
            } else {
                $query->where(function ($q) use ($filter) {
                    $this->applyMultiFilters($q, $filter);
                });
            }
        }
    }

    /**
     *  Grouped filters can be applied like so:
     *  filters[]=fname,like,'%john%'||sname,like,'%john%',or||email,like,'%john%'||or
     *  the or at the end determines whether the group is a `where` or an `orWhere` query
     *  if left blank, it's a `where`
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array                                 $filters
     **/
    protected function applyMultiFilters(Builder $query, array $filter)
    {
        if (is_array($filter[0])) {
            $boolean = !is_array(last($filter)) && strtolower(last($filter)) === 'or' ? 'or' : 'and';
            $query->where(function ($q) use ($filter, $boolean) {
                foreach ($filter as $c => $f) {
                    if ($c === (count($filter) - 1) && $boolean === 'or') {
                        continue;
                    }
                    $this->applyQueryOperands($q, $filter);
                }
            }, null, null, $boolean);
        } else {
            $this->applyQueryOperands($query, $filter);
        }
    }

    /**
     * Apply the query filters to the query matching the operands used
     *
     * @param Builder $query
     * @param array   $filter
     *
     * @return Builder
     */
    protected function applyQueryOperands($query, $filter = [])
    {
        if (! is_array($filter)) {
            throw new InvalidArgumentException('Filter needs to consist of arrays');
        }
        if (count($filter) < 3) {
            throw new InvalidArgumentException('Filter needs to have three values. field name, operator and value');
        }

        $boolean = isset($filter[3]) && $filter[3] == 'or' ? 'or' : 'and';

        if ($filter[2] === 'null' &&  $filter[1] === '=') {
            $query->whereNull($filter[0], $boolean);
        } elseif ($filter[1] === 'In') {
            $query->whereIn($filter[0], explode('|', $filter[2]), $boolean);
        } elseif ($filter[1] === 'between') {
            $query->whereBetween($filter[0], explode('|', $filter[2]), $boolean);
        } else {
            $query->where($filter[0], $filter[1], $filter[2], $boolean);
        }

        return $query;
    }

    /**
     * Apply the Has query filter. Negate the has filter to convert it to
     * a doesntHave filter.
     *
     * @param Builder $query
     * @param array   $filters
     */
    protected function applyHasFilters($query, $filters = [])
    {
        foreach ($filters as $filter) {
            $multiHas = explode('||', $filter);

            if (count($multiHas) > 1) {
                $this->mapMultiHas($query, $multiHas);

                continue;
            }

            $this->mapNormalHas($query, $filter);
        }
    }

    /**
     * Apply a multi-has or query. Use of two pipes on the same filter denote OR.
     * e.g. registers|id,In,[1,2,3]||registers|id,eq,4
     *
     * @param Builder $query
     * @param array   $filters
     */
    protected function mapMultiHas($query, $filters = [])
    {
        $query->where(function ($q) use ($filters) {
            foreach ($filters as $filter) {
                $this->mapNormalHas($q, $filter, true);
            }
        });
    }

    /**
     * Prepare the has query and map it to whereHas or basic has
     *
     * @param Builder $query
     * @param string  $filter
     * @param bool    $orWhere
     */
    protected function mapNormalHas($query, $filter, $orWhere = false)
    {
        $parsedFilter = explode('|', $filter);
        $parsedCount = count($parsedFilter);

        if ($parsedCount === 1) {
            $this->prepareHas($query, $parsedFilter[0], $orWhere);

            return;
        }

        if ($parsedCount === 2) {
            $this->prepareWhereHas($query, $parsedFilter, $orWhere);
        }
    }

    /**
     * Prepare the has query filter.
     *
     * @param Builder $query
     * @param string  $relation
     * @param bool    $orWhere
     *
     * @return Builder
     */
    protected function prepareHas($query, $relation, $orWhere = false)
    {
        if ($negated = strpos($relation, '!') === 0) {
            $relation = substr($relation, 1);
        }

        if ($orWhere) {
            return $negated
                ? $query->orDoesntHave($relation)
                : $query->orHas($relation);
        }

        return $negated
            ? $query->doesntHave($relation)
            : $query->has($relation);
    }

    /**
     * Apply the whereHas query filter.
     *
     * @param Builder $query
     * @param array   $filters
     * @param bool    $orWhere
     *
     * @return Builder
     */
    protected function prepareWhereHas($query, $filters = [], $orWhere = false)
    {
        $relation = $filters[0];
        $constraints = explode(',', preg_replace('/[\[\]]/', '', $filters[1]));
        $constraints = $this->mapConstraints(...$constraints);

        if (! $orWhere) {
            return $query
            ->whereHas($relation, function ($builder) use ($constraints) {
                $this->applyQueryOperands($builder, $constraints);
            });
        }

        return $query
            ->orWhereHas($relation, function ($builder) use ($constraints) {
                $this->applyQueryOperands($builder, $constraints);
            });
    }

    /**
     * Map the constraints from the client. e.g. 'registers|id,In,[1,2,3]'
     *
     * @param string $field
     * @param string $operand
     * @param array  ...$values
     *
     * @return array
     */
    protected function mapConstraints($field, $operand, ...$values)
    {
        if (count($values) === 1) {
            $values = $values[0];
        }

        if (is_array($values)) {
            $values = implode('|', $values);
        }

        return [$field, $operand, $values];
    }

    protected function applyIncludes($query, array $includes = [])
    {
        $updated = [];

        foreach ($includes as $include) {
            $parsedInclude = explode('@', $include);
            $parsedCount = count($parsedInclude);

            if ($parsedCount === 1) {
                $updated[] = $include;

                continue;
            }

            if ($parsedCount === 2) {
                $parsedRelation = explode(':', $parsedInclude[0]);
                $relation = $parsedRelation[0];
                $constraints = explode(',', preg_replace('/[\[\]]/', '', $parsedInclude[1]));
                $constraints = $this->mapConstraints(...$constraints);

                $updated[$relation] = function ($builder) use ($constraints, $parsedRelation) {
                    if (isset($parsedRelation[1])) {
                        $builder->select(explode(',', $parsedRelation[1]));
                    }
                    $this->applyQueryOperands($builder, $constraints);
                };
            }
        }

        $query->with($updated);

        return $query;
    }
}
