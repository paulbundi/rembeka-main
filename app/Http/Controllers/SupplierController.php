<?php

namespace App\Http\Controllers;

use App\Repository\Suppliers\SupplierRepository;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:suppliers.view')->only('index');
        $this->middleware('can-access:suppliers.create')->only('create');
        $this->middleware('can-access:suppliers.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'suppliers-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'suppliers-create']);
    }

    /**
     * @return void
     */
    public function show($id)
    {
        return view('dashboard.page', ['page' => 'suppliers-show', 'id' => $id]);
    }

    /**
     * @return void
     */
    public function edit($id)
    {
        return view('dashboard.page', ['page' => 'suppliers-create', 'id' => $id]);
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

        return view('dashboard.suppliers.income', $dashboard);
    }
}
