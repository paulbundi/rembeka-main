<?php

namespace App\Http\Controllers;

class NewsLetterController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:news-letter.view')->only('index');
        $this->middleware('can-access:news-letter.create')->only('create');
        $this->middleware('can-access:news-letter.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'news-letter-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'news-letter-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'news-letter-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'news-letter-show', 'id' => $id]);
    }
}
