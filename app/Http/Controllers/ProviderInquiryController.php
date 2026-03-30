<?php

namespace App\Http\Controllers;

class ProviderInquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:provider-inquiries.view')->only('index');
        $this->middleware('can-access:provider-inquiries.create')->only('create');
        $this->middleware('can-access:provider-inquiries.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'provider-inquiries-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'provider-inquiries-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'provider-inquiries-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'provider-inquiries-create', 'id' => $id]);
    }
}
