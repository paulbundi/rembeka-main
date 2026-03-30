<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressFormRequest;
use App\Models\Address;

class AddressController extends Controller
{
    /**
     * @return void
     */
    public function index()
    {
        $addresses =  Address::mine()
            ->get();

        return view('e-commerce.account.addresses.index', [
            'addresses' => $addresses,
        ]);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('e-commerce.account.addresses.create');
    }

    /**
     * @param AddressFormRequest $request
     *
     * @return void
     */
    public function store(AddressFormRequest $request)
    {

        $data = $request->validated();

        $data['user_id'] = auth()->id();

        if(isset($data['lat_long'])){
            $coordinates =  explode(',', $data['lat_long']);
            $data['lat'] = $coordinates[0];
            $data['long'] = $coordinates[1];
        }

        Address::create($data);

        return redirect()->route('addresses.index');
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        $address =  Address::mine()->where('id', $id)->firstOrFail();

        return view('e-commerce.account.addresses.create', ['address' => $address]);
    }

    /**
     * update address
     *
     * @param AddressFormRequest $request
     * @param int                $id
     *
     * @return void
     */
    public function update(AddressFormRequest $request, int $id)
    {

        $data =  $request->validated();

        if(isset($data['lat_long'])){
            $coordinates =  explode(',', $data['lat_long']);
            $data['lat'] = $coordinates[0];
            $data['long'] = $coordinates[1];
        }

        Address::where('id', $id)
            ->where('user_id', auth()->id())
            ->update([
                'name' => $data['name'],
                'lat' => $data['lat'],
                'long' => $data['long'],
                'appartment' => $data['appartment'],
                'floor' => $data['floor'],
                'room' => $data['room'],
            ]);

        return redirect()->route('addresses.index');
    }

    /**
     * update address
     *
     * @param AddressFormRequest $request
     * @param int                $id
     *
     * @return void
     */
    public function destroy(int $id)
    {
        Address::where('id', $id)
                ->where('user_id', auth()->id())
                ->delete();

        return redirect()->route('addresses.index');
    }
}
