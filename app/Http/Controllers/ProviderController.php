<?php

namespace App\Http\Controllers;

use App\Repository\Providers\ProviderRepository;

class ProviderController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:providers.view')->only('index');
        $this->middleware('can-access:providers.create')->only('create');
        $this->middleware('can-access:providers.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'providers-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'providers-create']);
    }

    /**
     * @return void
     */
    public function show($id)
    {
        return view('dashboard.page', ['page' => 'providers-show', 'id' => $id]);
    }

    /**
     * @return void
     */
    public function edit($id)
    {
        return view('dashboard.page', ['page' => 'providers-edit', 'id' => $id]);
    }

    /**
     * Stylist income.
     *
     * @param int $id
     *
     * @return void
     */
    public function stylistIncome(int $id)
    {
        $dashboard = (new ProviderRepository())->dashboard($id);

        return view('dashboard.stylists.income', $dashboard);
    }
}
