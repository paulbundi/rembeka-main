<?php

namespace App\Http\Controllers\Services;

use App\Exceptions\InvalidUriException;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * An HTTP layer service to
 */
class ApiRequestFilter
{
    /**
     * @var array
     */
    protected $allowedIncludes;

    /**
     * @var int
     */
    protected $defaultPerPage = 30;

    /**
     * @var array
     */
    protected $counts;

    /**
     * @var array
     */
    protected $fields;

    /**
     * @var array
     */
    protected $filters;

    /**
     * @var array
     */
    protected $has;

    /**
     * @var array
     */
    protected $ids;

    /**
     * @var array
     */
    protected $includes;

    /**
     * @var array
     */
    protected $order;

    /**
     * @var int|null
     */
    protected $page;

    /**
     * @var int
     */
    protected $perPage;

    /**
     * @var self
     */
    public static $instance;

    public function __construct(int $perPage, array $allowedIncludes = [])
    {
        $this->defaultPerPage = $perPage;
        $this->allowedIncludes = $allowedIncludes;
        $this->request = request();

        $this->setup();

        self::$instance = $this;
    }

    /**
     * Initialise the filter.
     */
    protected function setup()
    {
        $this->counts = $this->getCounts();
        $this->fields = $this->getFields();
        $this->filters = $this->getFilters();
        $this->has = $this->getHas();
        $this->ids = $this->getIds();
        $this->includes = $this->getIncludes();
        $this->order = $this->getOrder();
        $this->page = $this->getPage();
        $this->perPage = $this->getPerPage();
    }

    public static function instance(): ?self
    {
        return self::$instance;
    }

    /**
     * Returns a list of fields to show for the output
     *
     * @return array
     **/
    public function getFields()
    {
        if ($this->fields) {
            return $this->fields;
        }

        $fields = $this->request->input('fields', ['*']);

        return is_string($fields) ? explode(',', $fields) : $fields;
    }

    /**
     * Gets the ids from the query
     *
     * @return array
     **/
    public function getIds(): array
    {
        if ($this->ids) {
            return $this->ids;
        }

        $ids = $this->request->input('ids', ['*']);

        return is_string($ids) ? explode(',', $ids) : $ids;
    }

    /**
     * Gets the page from the query string
     *
     * @return int|null
     **/
    public function getPage()
    {
        if ($this->page) {
            return $this->page;
        }

        $page = $this->request->input('page', null);

        return $page ? (int)$page : null; //by default we will return all models
    }

    /**
     * Gets the per page count from the query string
     *
     * @return int
     **/
    public function getPerPage(): int
    {
        if ($this->perPage) {
            return $this->perPage;
        }

        return (int)$this->request->input('perPage', $this->defaultPerPage);
    }

    /**
     * Returns the filters formatted to be passed to the query
     *
     * @return array
     **/
    public function getFilters(): array
    {
        if ($this->filters) {
            return $this->filters;
        }

        $filters = $this->request->input('filters', []);

        $filtersOut = [];
        $count = 0;

        foreach ($filters as $filter) {
            $multiFilters = explode('||', $filter);

            if (count($multiFilters) > 1) {
                $filtersOut[$count] = [];
                foreach ($multiFilters as $multiFilter) {
                    $val = strtolower($multiFilter) !== 'or' ? $this->stripFilter($multiFilter) : 'or';
                    array_push($filtersOut[$count], $val);
                }
            } else {
                $filtersOut[$count] = $this->stripFilter($multiFilters[0]);
            }
            $count++;
        }

        return $filtersOut;
    }

    /**
     * Returns the filters formatted to be passed to the query
     *
     * @param string $filter
     *
     * @throws App\Exceptions\InvalidUriException
     *
     * @return array
     **/
    protected function stripFilter(string $filter): array
    {
        $filter = explode(',', $filter);

        if (!is_array($filter) || count($filter) < 3) {
            throw new InvalidUriException(
                SymfonyResponse::HTTP_BAD_REQUEST,
                trans('exceptions.invalid_uri.filter')
            );
        }

        list($field, $operator, $value) = array_values($filter);
        $operator = config('filter.filter_operators')[$operator];

        $boolean = $filter[3] ?? 'and';
        $out = [$field, $operator, $value, $boolean];

        return $out;
    }

    /**
     * Returns the order as required by the query builder
     *
     * @return array
     **/
    public function getOrder(): array
    {
        if ($this->order) {
            return $this->order;
        }

        $order = $this->request->input('sort', '');

        if ($order == '' || $order == null) {
            return [];
        }
        $orderOut = [];

        $order = explode(',', $order);

        foreach ($order as $field) {
            if (Str::startsWith($field, '-')) {
                $direction = 'desc';
                $field = substr($field, 1);
            } else {
                $direction = 'asc';
            }

            $orderOut[] = [
                $field,
                $direction
            ];
        }

        return $orderOut;
    }

    /**
     * Returns the counts formatted to be passed to the query
     *
     * @return array
     **/
    public function getCounts(): array
    {
        if ($this->counts) {
            return $this->counts;
        }

        if (!$this->request->has('count')) {
            return [];
        }

        $counts = $this->request->input('count');

        return explode(',', $counts);
    }

    /**
     * Returns the relationship constraints formatted to be passed to the query.
     * e.g. 'registers|id,In,[1,2,3]'
     *
     * @return array
     **/
    public function getHas(): array
    {
        if ($this->has) {
            return $this->has;
        }

        if (!$this->request->has('has')) {
            return [];
        }

        $has = $this->request->input('has');

        return is_array($has) ? $has : [];
    }

    /**
     * @return array
     **/
    public function getIncludes(): array
    {
        $includes = explode(',', $this->request->input('include', ''));

        return array_intersect($this->allowedIncludes, $includes);
    }
}
