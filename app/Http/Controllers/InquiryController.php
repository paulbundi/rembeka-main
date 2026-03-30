<?php

namespace App\Http\Controllers;

class InquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:inquiries.view')->only('index');
        $this->middleware('can-access:inquiries.create')->only('create');
        $this->middleware('can-access:inquiries.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'inquiries-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'inquiries-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'inquiries-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'inquiries-show', 'id' => $id]);
    }
}
