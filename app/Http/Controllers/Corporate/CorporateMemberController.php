<?php

namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;

class CorporateMemberController extends Controller
{
    /**
     * corporate members index
     *
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'corporate-members-index']);
    }

    /**
     * corporate members index
     *
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'corporate-members-create']);
    }
}
