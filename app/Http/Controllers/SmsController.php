<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:sms-campaigns.view')->only('index');
        $this->middleware('can-access:sms-campaigns.create')->only('create');
        $this->middleware('can-access:sms-campaigns.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'sms-campaign-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'sms-campaign-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'sms-campaign-create', 'id' => $id]);
    }


    /**
     * Sms callback
     *
     * @param Request $request
     * @return void
     */
    public function smsCallback(Request $request)
    {
        $data = $request->all();
        $phone = substr($data['phoneNumber'], -9);
        $user = User::where('phone', 'like', '%'.$phone)->first();
        if ($user) {
            $user->sms_blocked = User::SMS_BLOCKED;
            $user->save();
        }
    }
}
