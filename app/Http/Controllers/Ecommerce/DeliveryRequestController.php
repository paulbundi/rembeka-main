<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressFormRequest;
use App\Models\DeliveryRequest;
use App\Models\Driver;
use App\Models\Order;
use App\Models\Rating;
use App\Models\TransportRequest;
use App\Notifications\SmsNotification;
use Illuminate\Http\Request;

class DeliveryRequestController extends Controller
{
    /**
     * @param AddressFormRequest $request
     *
     * @return void
     */
    public function index()
    {
        $driver = Driver::where('user_id', auth()->id())->first();
        $orders = Order::where('driver_id', $driver->id)
            ->with(['address', 'deliveryRequests' => function($qry) {
                $qry->where('user_id', auth()->id());
            }])
            ->latest()
            ->paginate();

        return view('e-commerce.account.delivery-request.index', ['orders' => $orders]);
    }

    /**
     * Service Request.
     *
     * @param int $id
     *
     * @return void
     */
    public function completeRequest(int $id)
    {
        //NB:This shld complete order item-> not full order.
        $otp =  rand(1000, 9999);
        $order = Order::findOrFail($id);
        $order->status = Order::STATUS_FULFILLED;
        $order->otp = $otp;
        $order->save();

        $message = 'Dear Customer one time password(OTP) to complete your service is'. $otp .' Thank you for booking via rembeka.com';

        $order->customer->notify(new SmsNotification($message));

        return view('e-commerce.account.service-request.client-rating', ['order' => $order]);
    }

    /**
     * @param Request $request
     *
     * @return void
     */
    public function clientRating(Request $request)
    {
        $data =  $request->validate([
            'order_id' => ['required'],
            'rating' => ['required'],
            'comment' => ['nullable'],
        ]);

        $order =  Order::findOrFail($data['order_id']);

        // if ($order->otp != $data['otp']) {
        //     return redirect()->route('service-requests.index')->with('error', 'Please provide a valid Otp');
        // }
        $data['rateable_id'] = $order->user_id;
        $data['rateable_type'] = 'App\Models\Order';
        $data['user_id'] = auth()->id();

        Rating::create($data);

        return redirect()->route('service-requests.index')->with('success', 'Rating successful');
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function requestForTransport(int $id)
    {
        $driver =  Driver::where('user_id', auth()->id())->first();

        $order = Order::where('driver_id', $driver->id)
            ->whereNull('driver_paid')
            ->with(['items', 'deliveryRequests'])
            ->findOrFail($id);

        if ($order->deliveryRequests) {
            $request = $order->deliveryRequests->where('user_id', auth()->id())->first();

            if ($request) {
                return redirect()->route('delivery-requests.index')
                ->with([
                    'message' =>[
                        'type' => 'error',
                        'message' => 'Please contact office for assistance!',
                    ],
                ]);
            }
        }

        DeliveryRequest::create([
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'amount' => $order->delivery_amount,
            'status' => DeliveryRequest::STATUS_PENDING,
        ]);

        return redirect()->route('delivery-requests.index')
            ->with([
                'message' =>[
                    'type' => 'success',
                    'message' => 'Request made successfully',
                ]
            ]);
    }
}
