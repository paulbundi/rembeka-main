<?php

namespace App\Http\Controllers\Api;

use App\Models\Inquiry;
use App\Models\InquiryActivity;
use App\Models\User;
use Illuminate\Http\Request;

class InquiryController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return Inquiry::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'user', 'channel', 'product', 'assigned',
        ];
    }

    /**
     * @param Request $request
     * @param int     $modelId
     *
     * @return void
     */
    public function preUpdate(Request $request, $modelId)
    {
        if ($this->model->isDirty('assigned_id')) {
            $user =  User::findOrFail($this->model->assigned_id);

            InquiryActivity::create([
                'user_id' => auth()->id(),
                'inquiry_id' => $modelId,
                 'activity' => InquiryActivity::ACTIVITY_ASSIGNMENT_CHANGED,
                 'title' => 'Inquiry re-assigned.',
                 'description' => 'Inquiry was assigned to '. $user->name,
            ]);
        }
    }
}
