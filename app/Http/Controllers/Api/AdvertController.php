<?php

namespace App\Http\Controllers\Api;

use App\Models\Advert;
use App\Models\Attachment;
use Illuminate\Http\Request;

class AdvertController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return Advert::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'product', 'attachments.media',
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postStore(Request $request)
    {
        if ($request->get('banner_image')) {
            Attachment::updateOrCreate([
                'attachable_id' => $this->model->id,
                'attachable_type' => 'App\Models\Advert',
            ], [
                'user_id' => auth()->id(),
                'media_id' => $request->get('banner_image'),
            ]);
        }
    }
}
