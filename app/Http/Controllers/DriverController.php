<?php

namespace App\Http\Controllers;

use App\Repository\Suppliers\SupplierRepository;

class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:drivers.view')->only('index');
        $this->middleware('can-access:drivers.create')->only('create');
        $this->middleware('can-access:drivers.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'drivers-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'drivers-create']);
    }

    /**
     * @return void
     */
    public function show($id)
    {
        return view('dashboard.page', ['page' => 'drivers-show', 'id' => $id]);
    }

    /**
     * @return void
     */
    public function edit($id)
    {
        return view('dashboard.page', ['page' => 'drivers-create', 'id' => $id]);
    }

    /**
     * Stylist income.
     *
     * @param int $id
     *
     * @return void
     */
    public function supplierIncome(int $id)
    {
        $dashboard = (new SupplierRepository())->dashboard($id);

        return view('dashboard.drivers.income', $dashboard);
    }
}
