<?php

namespace App\Http\Controllers\Api;

use App\Models\Attachment;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProductController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return Product::class;
    }

    /**
     * Get a new query instance.
     *
     * @return Builder
     */
    protected function newQuery(): Builder
    {
        return $this->model->newQuery()
            ->where('type', Product::TYPE_PRODUCT);
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'users', 'attachments', 'attachments.media', 'menu', 'ageGroups', 'brand'
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postStore(Request $request)
    {
        $data = $request->all();
        if (isset($data['age_groups']) && count($data['age_groups']) > 0) {
            $this->model->ageGroups()->attach($data['age_groups']);
        }
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
    public function attachMorphRelations(Request $request, $id, $relationName)
    {
        $this->model = $this->model->findOrFail($id);
        if (! method_exists($this->model, $relationName)) {
            throw new BadRequestHttpException('relation doesnt exist', null, 400);
        }

        $ids = $request->input('data', []);
        foreach ($ids as $mediaId) {
            Attachment::create([
                'user_id' => auth()->id(),
                'attachable_id' => $this->model->id,
                'attachable_type' => 'App\Models\Product',
                'media_id' => $mediaId,
            ]);
        }

        return response()->json();
    }

    /**
     * Dettache the given many to many relations.
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $id
     * @param string                   $relationName
     *
     * @return \Illuminate\Http\Response
     */
    public function dettachMorphRelations(Request $request, $id, $relationName)
    {
        $this->model = $this->model->findOrFail($id);
        if (! method_exists($this->model, $relationName)) {
            throw new BadRequestHttpException('relation doesnt exist', null, 400);
        }

        $ids = $request->input('data', []);
        foreach ($ids as $attachementId) {
            Attachment::where('id', $attachementId)->delete();
        }

        return response()->json();
    }
}
