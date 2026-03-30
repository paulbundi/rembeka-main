<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:menus.view')->only('index');
        $this->middleware('can-access:menus.create')->only('create');
        $this->middleware('can-access:menus.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'menus-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'menus-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'menus-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'menus-show', 'id' => $id]);
    }

    /**
     * Generate Qr Codes.
     *
     * @param integer $id
     * @return void
     */
    public function generateQrCode(int $id)
    {
        $menu = Menu::findOrFail($id);
        
        return view('dashboard.qr-view', ['menu' => $menu]);
    }
}
