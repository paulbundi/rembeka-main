<?php

namespace App\Http\Controllers\Api;

use App\Models\InquiryActivity;
use Illuminate\Http\Request;

class InquiryActivityController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return InquiryActivity::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'user',
        ];
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
        if (!$this->model->id && !$request->get('title')) {
            $this->model->title =  $this->getTittle($request->get('activity'));
        }

        $this->model->save();
        $this->postStore($request);

        return $this->getModelResource()
            ->toResponse($request)
            ->setStatusCode(201);
    }

    /**
     * get engagement title.
     *
     * @param int $activity
     *
     * @return string
     */
    public function getTittle(int $activity): string
    {
        if ($activity == InquiryActivity::ACTIVITY_CALL) {
            return  'Phone call engagement.';
        }
        if ($activity == InquiryActivity::ACTIVITY_SMS) {
            return  'Sent an SMS.';
        }
        if ($activity == InquiryActivity::ACTIVITY_WHATSAPP) {
            return  'Engagement via Whatsapp.';
        }

        return  'Engagement via social media.';
    }
}
