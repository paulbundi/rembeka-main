<?php

namespace App\Http\Controllers\Api;

use App\Models\Attachment;
use App\Models\ProviderProfile;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProviderProfileController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return ProviderProfile::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'provider',
        ];
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
            throw new BadRequestHttpException('relation doesn`t exist', null, 400);
        }

        $ids = $request->input('data', []);
        foreach ($ids as $attachementId) {
            Attachment::where('id', $attachementId)->delete();
        }

        return response()->json();
    }
}
