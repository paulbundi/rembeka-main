<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressFormRequest;
use App\Models\Order;
use App\Models\Rating;
use App\Models\TransportRequest;
use App\Notifications\SmsNotification;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    /**
     * @param AddressFormRequest $request
     *
     * @return void
     */
    public function index()
    {
        $orders = Order::whereHas('items', function ($query) {
            $query->where('provider_id', auth()->user()->organization_id)//based on organization
            ->orWhere('assisting_provider_id', auth()->user()->organization_id);//based on organization
        })->with(['items.product','items.provider', 'items.assistingProvider','customer', 'location', 'transportRequests', 'items' => function ($query) {
            return $query->where('provider_id', auth()->user()->organization_id)
                ->orWhere('assisting_provider_id', auth()->user()->organization_id);
        }])
        ->orderBy('id', 'DESC')
        ->paginate();

        return view('e-commerce.account.service-request.index', ['orders' => $orders]);
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
        $order = Order::with(['items', 'transportRequests'])->findOrFail($id);

        if ($order->transportRequests) {
            $request = $order->transportRequests->where('user_id', auth()->id())->first();

            if ($request) {
                return redirect()->route('service-requests.index')
                ->with([
                    'message' =>[
                        'type' => 'error',
                        'message' => 'Please contact office for assistance!',
                    ],
                ]);
            }
        }

        $item = $order->items->filter(function ($item) {
            if ($item->provider_id == auth()->user()->organization_id || $item->assisting_provider_id == auth()->user()->organization_id) {
                return true;
            }
        });

        if ($item == null) {
            return redirect()->route('service-requests.index')
                ->with([
                    'message' =>[
                        'type' => 'error',
                        'message' => 'Please contact office for assistance!',
                    ],
                ]);
        }

        TransportRequest::create([
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'amount' => TransportRequest::TRANSPORT_COST,
            'status' => TransportRequest::STATUS_PENDING,
        ]);

        return redirect()->route('service-requests.index')
            ->with([
                'message' =>[
                    'type' => 'success',
                    'message' => 'Request made successfully',
                ]
            ]);
    }
}
