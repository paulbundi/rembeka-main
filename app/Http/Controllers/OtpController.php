<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\SmsNotification;
use App\Notifications\WelcomeToRembeka;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    /**
     *Generate otp
     *
     * @return void
     */
    public function index()
    {
        return view('e-commerce.otp.index');
    }

    /**
     *verify Otp
     *
     * @return void
     */
    public function verify(Request $request)
    {
        $data =  $request->all();
        if (!$this->isValidOtp($data)) {
            return redirect()->route('otp')->with([
                'error' => 'Invalid OTP',
            ]);
        }

        User::where('id', auth()->id())->update([
            'phone_verified' => 1
        ]);

        $intended = session('intended-route');

        if (session('new-user')) {
            auth()->user()->notify(new WelcomeToRembeka());
        }

        if (!$intended) {
            return redirect()->route('home')->with([
                'message' =>[
                    'type' => 'success',
                    'message' => 'Account verified successfully',
                ],
            ]);
        }
        session()->forget('intended-route');

        return redirect()->route($intended);
    }

    /**
     * @return bool
     */
    public function isValidOtp(array $data)
    {
        $opt = session('otp');

        if (now()->lte($opt['expires']) && $data['otp'] == $opt['otp']) {
            session()->forget('otp');

            return true;
        }

        return false;
    }

    /**
     * Resend Notifications
     *
     * @return void
     */
    public function reSendOtp()
    {
        $message = getOtpMessage();
        auth()->user()->notify(new SmsNotification($message, true));

        return redirect()->route('otp')->with('otp-to-mail', 'Otp has been shared via email');
    }
}
