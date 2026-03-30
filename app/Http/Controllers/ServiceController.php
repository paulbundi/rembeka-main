<?php

namespace App\Http\Controllers;

use App\Imports\ProductsImport;
use App\Imports\ProductsImportUpdate;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:services.view')->only('index');
        $this->middleware('can-access:services.create')->only('create');
        $this->middleware('can-access:services.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'services-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'services-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'services-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'services-create', 'id' => $id]);
    }

    /**
     * @return void
     */
    public function getProductImportView()
    {
        return view('dashboard.services-import');
    }

    /**
     * import parents from a csv file.
     *
     * @param Request $request
     *
     * @return void
     */
    public function importProducts(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xlsx',
            'selected' => 'required',
        ]);

        Excel::import(new ProductsImport($request->selected), $request->file('file'));

        return redirect()->route('import-products.index') ->with([
            'message' =>[
                'type' => 'success',
                'message' => 'Product Imported successfully',
            ],
        ]);
    }

    /**
     * import parents from a csv file.
     *
     * @param Request $request
     *
     * @return void
     */
    public function importProductUpdates(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xlsx',
        ]);

        Excel::import(new ProductsImportUpdate(), $request->file('file'));

        return redirect()->route('import-products.index') ->with([
            'message' =>[
                'type' => 'success',
                'message' => 'Product Updated successfully',
            ],
        ]);
    }
}
