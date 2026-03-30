<?php

namespace App\Http\Controllers;

use App\Facades\Cart;
use App\Http\Requests\AddToCartFormRequest;
use App\Http\Requests\CheckOutFormRequest;
use App\Http\Requests\CheckOutRequest;
use App\Http\Requests\PaymentFormRequest;
use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use App\Notifications\SmsNotification;
use App\Repository\Cart\CartRepository;
use App\Repository\Payment\MpesaValidationRepository;
use Doctrine\Common\Cache\Cache;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Add to cart
     *
     * @param AddToCartFormRequest $request
     *
     * @return void
     */
    public function addToCart(AddToCartFormRequest $request)
    {
        $data = $request->validated();

        Cart::store($data);

        return response()->json(['data' => Cart::toArray()]);
    }

    /**
     * Remove items from cart.
     *
     * @param Type|null $var
     *
     * @return void
     */
    public function removeFromCart(string $id)
    {
        Cart::remove($id);

        return redirect()->route('checkout.cart');
    }

    /**
     * Cart details page
     *
     * @return void
     */
    public function checkout()
    {
        return view('e-commerce.checkouts.create');
    }

    /**
     * Redirect to checkout user details form.
     *
     * @return void
     */
    public function checkoutDetails()
    {
        $addresses = null;
        if (auth()->check()) {
            $addresses = Address::mine()->get();
        }

        return view('e-commerce.checkouts.checkout-details', ['addresses' => $addresses]);
    }

    /**
     * @return void
     */
    public function paymentMode(Request $request)
    {
        if (request()->method() == 'GET') {
            return view('e-commerce.checkouts.payment-mode');
        }

        $data = $this->validate($request, [
            'name' => 'required_if:address_id,null',
            'address_id' => 'required_if:name,null',
            'lat_long'=> 'required_with:name',
            'appartment'=> 'required_with:name',
            'floor'=> 'nullable',
            'room'=> 'nullable',
        ]);

        $id = isset($data['address_id']) ? $data['address_id'] : null;

        if (!isset($data['address_id'])) {
            $coordinates = explode(',', $data['lat_long']);
            $data['lat'] = $coordinates[0];
            $data['long'] = $coordinates[1];
            $data['user_id'] = auth()->id();
            $id = Address::create($data)->id;
        }

        session()->put('address_id', $id);

        return view('e-commerce.checkouts.payment-mode');
    }

    /**
     * @param Request $request
     *
     * @return void
     */
    public function createAccount(CheckOutRequest $request)//CheckOutFormRequest
    {
        $data =  $request->validated();

        if (auth()->check() && count(Cart::items()) > 0) {//TODO: check has phone number validated
            return redirect()->route('payment.mode');
        } elseif (auth()->check()) {
            return redirect()->route('home');
        }
        $user =  User::create($data);

        $content = Cart::getContent();

        auth()->login($user);

        if(isset($data['lat_long'])) {
            $coordinates = explode(',',$data['lat_long']);
            $data['lat'] = $coordinates[0];
            $data['long'] = $coordinates[1];
        }

        $address = Address::create([
            'user_id' => auth()->id(),
            'name' => $data['name'],
            'lat' => $data['lat']?? null,
            'long' => $data['long']?? null,
            'appartment' => $data['appartment'],
            'floor' => $data['floor'],
            'room' => $data['room'],
        ]);

        $cart = Cart::session(session()->getId());

        $guestCartItems = $content->toArray();

        if ($content->isNotEmpty()) {
            $cart->add($guestCartItems);
        }

        session()->put('address_id', $address->id);

        if ($content->isNotEmpty()) {

            return redirect()->route('payment.mode');
        }

        // if ($user) {
        //     $user->notify(new SmsNotification(getOtpMessage(true)));

        //     return redirect()->route('otp');
        // }

        return redirect()->route('home');
    }

    /**
     * Create order and trigger STK PUSH.
     *
     * @param Request $request
     *
     * @return void
     */
    public function completeOrder(PaymentFormRequest $request, CartRepository $cartRepository)
    {
        $response = $cartRepository->createOrder($request->phone);

        return view('e-commerce.checkouts.payment-mode', ['response' =>$response]);
    }



    /**
     * Create order and trigger STK PUSH.
     *
     * @param Request $request
     *
     * @return void
     */
    public function PayOnDelivery(Request $request, CartRepository $cartRepository)
    {
        $response = $cartRepository->createOrder($request->phone, true);

        return view('e-commerce.checkouts.payment-complete', [
            'order' => $response['order']
        ]);
    }

    
    /**
     * Validate payment.
     *
     * @param MpesaValidationRepository $validatePayment
     *
     * @return void
     */
    public function validateStkPayment(MpesaValidationRepository $validatePayment)
    {
        $response = $validatePayment->validateTopUp(false);

        if (isset($response['transaction'])) {
            $order =  Order::with('items')
                ->where('order_no', $response['transaction']->reference_id)
                ->first();

            if (isset($response['type']) && $response['type'] =='success') {
                return view('e-commerce.checkouts.payment-complete', [
                        'order' => $order
                    ]);
            } else {
                return view('e-commerce.checkouts.payment-mode', ['response' =>$response]);
            }
        }

        return redirect()->route('home')->with([
            'message' =>[
                'type' => 'error',
                'message' => 'Failed to make payment, we will contact you shortly to help out',
            ],
        ]);
    }

    /**
     * Additional order-notes.
     *
     * @param Request $request
     *
     * @return void
     */
    public function additionalInformation(Request $request)
    {
        $data =  $request->validate([
            'notes' => 'required',
        ]);

        session()->put('notes', $data['notes']);

        return response()->json();
    }
}
