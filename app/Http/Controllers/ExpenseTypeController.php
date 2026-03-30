<?php

namespace App\Http\Controllers;

class ExpenseTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:expense-type.view')->only('index');
        $this->middleware('can-access:expense-type.create')->only('create');
        $this->middleware('can-access:expense-type.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'expense-type-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'expense-type-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'expense-type-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'expense-type-create', 'id' => $id]);
    }
}
