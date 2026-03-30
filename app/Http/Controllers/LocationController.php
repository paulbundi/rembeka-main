<?php

namespace App\Http\Controllers;

use App\Models\Location;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:locations.view')->only('index');
        $this->middleware('can-access:locations.create')->only('create');
        $this->middleware('can-access:locations.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'locations-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'locations-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'locations-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'locations-show', 'id' => $id]);
    }

    /**
     * Unzoned locations.
     *
     * @return void
     */
    public function unzonedLocations()
    {
        $locations =  Location::active()->paginate(15);

        return response()->json($locations);
    }

    /**
     * Selected locations.
     *
     * @param string $searchString
     *
     * @return void
     */
    public function searchLocation(String $searchString)
    {
        $locations =  Location::where('name', 'like', '%'.$searchString.'%')
            // ->orwhere('aliases', 'like', '%'.$searchString.'%')
            ->paginate();

        return response()->json(['data' => $locations]);
    }
}
