<?php

namespace App\Http\Controllers;

use App\Imports\BulkUpdate;
use App\Imports\ProductsImport;
use App\Imports\ProductsImportUpdate;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:services.view')->only('index');
        $this->middleware('can-access:products.create')->only('create');
        $this->middleware('can-access:products.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'products-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'products-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'products-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'products-create', 'id' => $id]);
    }

    /**
     * Show page to received the supplier Products
     *
     * @return void
     */
    public function receiveSupplierProducts()
    {
        return view('dashboard.page', ['page' => 'products-receive-products']);
    }

    /**
     * @return void
     */
    public function getProductImportView()
    {
        return view('dashboard.products-import');
    }

        /**
     * @return void
     */
    public function getBulkUpdateView()
    {
        return view('dashboard.bulk-import');
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
    public function bulkUpdate(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xlsx',
        ]);

        
        try {
            Excel::import(new BulkUpdate(), $request->file('file'));
            return redirect()->route('bulk-update.merchandise') ->with([
                'message' =>[
                    'type' => 'success',
                    'message' => 'Product Imported successfully',
                ],
            ]);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        } catch (\Exception $e) {
            return redirect()->route('bulk-update.merchandise') ->with([
                'message' =>[
                    'type' => 'error',
                    'message' => 'Could not import Check document headers!',
                ],
            ]);
        }

       
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


    /**
     * Generate site maps
     *
     * @return void
     */
    public function generateSiteMap() 
    {

        $path = public_path('/sitemaps.xml');

        SitemapGenerator::create('https://rembeka.com')
        ->hasCrawled(function (Url $url) {
            if ($url->segment(1) === 'contact') {
                return;
            }

            return $url;
        })
        ->writeToFile($path);
    }
}
