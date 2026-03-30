<?php

namespace App\Http\Controllers\Api;

use App\Models\Attachment;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return Partner::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'user', 'logo',
        ];
    }

    /**
     * handle image attachment,
     *
     * @param Request $request
     *
     * @return void
     */
    public function postStore(Request $request)
    {
        $this->handlePartnerLogo($request);
    }

    /**
     * handle image attachment,
     *
     * @param Request $request
     *
     * @return void
     */
    public function postUpdate(Request $request, $modelId)
    {
        if ($request->get('attachement_id')) {
            $this->handlePartnerLogo($request);
        }
    }

    /**
     * update provider Image
     *
     * @param [type] $request
     *
     * @return void
     */
    public function handlePartnerLogo($request)
    {

        Attachment::updateOrCreate([
            'attachable_id' => $this->model->id,
            'attachable_type' => 'App\Models\Partner',
        ], [
        'user_id' => auth()->id(),
        'media_id' => $request->get('media_id'),
        ]);
    }
}
