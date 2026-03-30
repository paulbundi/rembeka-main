<?php

namespace App\Http\Controllers\Auth;

use App\Facades\Cart;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedSessionController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/orders';

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $content = Cart::getContent();

        $request->authenticate();

        $request->session()->regenerate();

        $cart = Cart::session(session()->getId());

        $guestCartItems = $content->toArray();

        if ($content->isNotEmpty()) {
            $cart->add($guestCartItems);
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * @param $provider
     *
     * @return void
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Social Profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {

        try {

            $user = Socialite::driver($provider)->user();

            if (!$user->getEmail()) {

                return redirect()->route('register')->with('error', 'Due to privacy Policies, We did not get your profile details. Please proceed by creating an account with us');
            }
            $authUser = User::firstOrCreate(
                ['email' =>  $user->email],
                [
                    'name' => $user->name,
                    'provider' => $provider,
                    'provider_id' => $user->id,
                    'avatar' => $user->avatar,
                    'email_verified_at' => Carbon::now(),
                    'phone' => Str::random(20),
                ]
            );

            if ($authUser->status != User::STATUS_ACTIVE) {
                return redirect()->route('login');
            }

            $content = Cart::getContent();

            request()->session()->regenerate();
            
            $cart = Cart::session(session()->getId());
            $guestCartItems = $content->toArray();

            Auth::login($authUser, true);

            if ($content->isNotEmpty()) {
                $cart->add($guestCartItems);
            }
            return redirect($this->redirectTo);

        }catch(\Exception $e) {
            return redirect()->route('login')->with('error', 'Error verifying your details, Login if you have an account or proceed to register if you don`t have an account with us.');
        }
    }
}
