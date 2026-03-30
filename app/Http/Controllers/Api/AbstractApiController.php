<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Services\ApiQueryBuilder;
use App\Http\Controllers\Services\ApiRequestFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

abstract class AbstractApiController extends Controller
{
    /**
     * Default per page.
     *
     * @var int
     */
    protected $perPage = 4;

    /**
     * Api resource.
     *
     * @var String;
     */
    protected $resource;
    /**
     * Generate Model.
     *
     * @var Model
     */
    protected $model;

    /**
     * get current model.
     *
     * @return string
     */
    abstract protected function getModel(): string;

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    abstract protected function getAllowedIncludes(): array;

    /**
     * Create new instance.
     */
    public function __construct()
    {
        $model = $this->getModel();
        $this->model = new $model;
        $this->resource = $this->model::getApiResourceClass();
    }

    /**
     * Get a new query instance.
     *
     * @return Builder
     */
    protected function newQuery(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * Fetch all.
     *
     * @return JsonResource
     */
    public function index(): JsonResource
    {
        $results = $this->processListingQuery($this->newQuery());

        return $this->resource::collection($results);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($modelId)
    {
        $query = $this->newQuery()->whereKey($modelId);

        $this->model = $this->processListingQuery($query, false);

        return new $this->resource($this->model);
    }

    /**
     * Create a new Record.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = $this->getRequest();
        $this->preStore($request);
        $this->model->fill($request->only(array_keys($request->rules())));
        $this->model->save();
        $this->postStore($request);

        return $this->getModelResource()
            ->toResponse($request)
            ->setStatusCode(201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update($modelId)
    {
        $request = $this->getRequest();

        $this->model = $this->model->findOrFail($modelId);

        $this->model->fill($request->only(array_keys($request->rules())));

        $this->preUpdate($request, $modelId);

        $this->model->save();

        $this->postUpdate($request, $modelId);

        return $this->getModelResource($this->model);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->model->destroy($id);

        return response()->json();
    }

    /**
     * Add the query parameters and prepare the listing response.
     *
     * @param Builder $query
     * @param bool    $collection
     *
     * @return Builder
     */
    protected function processListingQuery($query, bool $collection = true)
    {
        $requestFilter = new ApiRequestFilter($this->perPage, $this->getAllowedIncludes());

        if ($requestFilter->getFields() !== ['*']) {
            $query->select($requestFilter->getFields());
        }

        $query = app(ApiQueryBuilder::class)->buildFilteredQuery($query, $requestFilter);

        if (! empty($requestFilter->getCounts())) {
            $query->withCount($requestFilter->getCounts());
        }
        if ($collection) {
            return $requestFilter->getPage()
                ? $query->paginate($requestFilter->getPerPage())
                : $query->get();
        }

        return $query->firstOrFail();
    }

    /**
     * Returns a single model resource for this model.
     *
     * @param \Illuminate\Database\Eloquent\Model $resource
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    protected function getModelResource() : JsonResource
    {
        // $this->loadRelations($entity);
        return new $this->resource($this->model);
    }

    /**
     * Get the current request.
     *
     * @return FormRequest
     */
    protected function getRequest()
    {
        return app($this->model::getFormRequestClass());
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function preStore(FormRequest $request)
    {
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postStore(FormRequest $request)
    {
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $id
     *
     * @return \Illuminate\Http\Response
     */
    public function preUpdate(FormRequest $request, $id)
    {
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $id
     *
     * @return \Illuminate\Http\Response
     */
    public function postUpdate(FormRequest $request, $id)
    {
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param string                   $id
     */
    public function preDestroy(FormRequest $request, $id)
    {
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Model                    $entity
     *
     * @return \Illuminate\Http\Response
     */
    public function preShow(FormRequest $request, Model $entity)
    {
    }

    /**
     * Attaches the given many to many relations.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $id
     * @param string                   $relationName
     *
     * @return \Illuminate\Http\Response
     */
    public function attachRelations(Request $request, $id, $relationName)
    {
        $this->model = $this->model->findOrFail($id);
        if (! method_exists($this->model, $relationName)) {
            throw new BadRequestHttpException('relation doesnt exist', null, 400);
        }

        $ids = $request->input('data', []);
        $this->model->{$relationName}()->syncWithoutDetaching($ids);

        // $attributes = $request->input('pivots', []);
        // $this->_updatePivots($relationName, $ids, $attributes);

        return response()->json();
    }

    /**
     * Detaches the given many to many relations.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $id
     * @param string                   $relationName
     *
     * @return \Illuminate\Http\Response
     */
    public function detachRelations(Request $request, $id, $relationName)
    {
        $this->model = $this->model->findOrFail($id);
        if (! method_exists($this->model, $relationName)) {
            throw new BadRequestHttpException('relation doesnt exist', null, 400);
        }
        $ids = $request->input('data', []);
        if (! empty($ids)) {
            $this->model->{$relationName}()->detach($ids);
        }

        return response()->json();
    }
}
