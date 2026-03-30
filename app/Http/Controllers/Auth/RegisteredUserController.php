<?php

namespace App\Http\Controllers\Auth;

use App\Facades\Cart;
use App\Http\Controllers\Controller;
use App\Models\Referralcode;
use App\Models\User;
use App\Notifications\SmsNotification;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (array_key_exists('code', request()->all()) && Referralcode::where('code', request()->get('code'))->exists()) {
            Cookie::queue('reg_code', request()->get('code'), 10080);
        }

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'terms' => ['required'],
            'privacy' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // 'g-recaptcha-response' => 'required|captcha',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'account_type' => User::TYPE_USER,
        ]);

        event(new Registered($user));

        $content = Cart::getContent();

        Auth::login($user);

        $cart = Cart::session(session()->getId());

        $guestCartItems = $content->toArray();

        if ($content->isNotEmpty()) {
            $cart->add($guestCartItems);
        }
        // $user->notify(new SmsNotification(getOtpMessage()));

        $this->hasCookie($user);

        session()->put('intended-route', 'home');
        session('new-user', true);

        if ($content->isNotEmpty()) {

            return redirect()->route('payment.mode');
        }
        // return redirect()->route('otp');

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Attach referrar.
     *
     * @param User $user
     *
     * @return bool
     */
    public function hasCookie(User $user)
    {
        $getCode = Cookie::get('reg_code');
        if (!$getCode) {
            return;
        }

        $code = Referralcode::where('code', $getCode)
            ->where('status', Referralcode::STATUS_ACTIVE)
            ->first();

        if ($code) {
            $code->users()->syncWithoutDetaching($user->id);
        }

        Cookie::queue(Cookie::forget('reg_code'));
    }
}
