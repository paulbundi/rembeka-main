<?php

namespace App\Http\Controllers;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:expenses.view')->only('index');
        $this->middleware('can-access:expenses.create')->only('create');
        $this->middleware('can-access:expenses.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'expenses-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'expenses-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'expense-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'expense-create', 'id' => $id]);
    }
}
