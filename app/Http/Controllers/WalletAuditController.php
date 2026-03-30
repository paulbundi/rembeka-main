<?php

namespace App\Http\Controllers;

class WalletAuditController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:wallet-audit.view')->only('index');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'wallet-audit-index']);
    }
}
