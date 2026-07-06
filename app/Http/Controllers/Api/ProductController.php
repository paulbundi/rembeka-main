<?php

namespace App\Http\Controllers\Api;

use App\Models\Attachment;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
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
        $this->resolveModel();

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
            'users', 'attachments', 'attachments.media', 'menu', 'ageGroups', 'brand',
            'category', 'supplierPrice', 'supplierPrice.unit', 'supplierPrice.supplier',
            'colors', 'variants', 'variants.attributes'
        ];
    }

    /**
     * @param \Illuminate\Foundation\Http\FormRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postStore(FormRequest $request)
    {
        $data = $request->all();
        if (isset($data['age_groups']) && count($data['age_groups']) > 0) {
            $this->model->ageGroups()->attach($data['age_groups']);
        }
        $this->syncColorVariants($data);
    }

    /**
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param string                                   $id
     *
     * @return \Illuminate\Http\Response
     */
    public function postUpdate(FormRequest $request, $id)
    {
        $data = $request->all();
        $this->syncColorVariants($data);
    }

    /**
     * Sync color variants from the color_variants array.
     *
     * @param array $data
     * @return void
     */
    protected function syncColorVariants(array $data): void
    {
        if (!isset($data['color_variants']) || !is_array($data['color_variants'])) {
            return;
        }

        // Collect color IDs for the pivot sync
        $colorIds = [];
        foreach ($data['color_variants'] as $variant) {
            if (!empty($variant['color_id'])) {
                $colorIds[] = $variant['color_id'];
            }
        }

        // Sync the product_color pivot table
        if (!empty($colorIds)) {
            $this->model->colors()->sync($colorIds);
        } else {
            $this->model->colors()->sync([]);
        }

        // Update or create variant records with stock
        foreach ($data['color_variants'] as $variant) {
            if (!empty($variant['color_id'])) {
                $color = \App\Models\Color::find($variant['color_id']);
                if ($color) {
                    $this->model->variants()->updateOrCreate(
                        ['color' => $color->name],
                        [
                            'sku' => $this->model->sku . '-' . $color->name,
                            'stock' => $variant['stock'] ?? 0,
                            'color' => $color->name,
                        ]
                    );
                }
            }
        }

        // Remove variants for colors that were unselected
        $keptColors = collect($data['color_variants'])
            ->pluck('color_id')
            ->filter()
            ->map(function ($id) {
                return \App\Models\Color::find($id)?->name;
            })
            ->filter();

        if ($keptColors->isNotEmpty()) {
            $this->model->variants()
                ->whereNotIn('color', $keptColors->toArray())
                ->delete();
        } elseif (empty($colorIds)) {
            $this->model->variants()->delete();
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
        $this->resolveModel();
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
        $this->resolveModel();
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