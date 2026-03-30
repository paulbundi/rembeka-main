<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ProviderPricing;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * @param int $id
     *
     * @return void
     */
    public function index()
    {
        $bookings = Booking::mine()
            ->latest()
            ->with(['providerPricing.product'])
            ->paginate(30);

        $services = ProviderPricing::where('provider_id', auth()->user()->organization_id)
            ->with(['product'])
            ->get();

        return view('e-commerce.account.bookings.index', [
            'bookings' => $bookings,
            'services' => $services,
        ]);
    }

    /**
     * make slot reservations
     *
     * @param Request $request
     *
     * @return void
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'service_id' => 'required',
            'slot_time' => 'required',
        ]);

        $data['provider_id'] =  auth()->user()->organization_id;

        Booking::create($data);

        return redirect()->route('book-slots.index')->with([
            'message' =>[
                'type' => 'success',
                'message' => 'Reservation made',
            ],
        ]);
    }
}
