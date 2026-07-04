<?php

namespace App\Http\Controllers;

use App\Models\AgeGroup;
use App\Models\Menu;
use App\Models\Product;
use App\Models\ProviderPricing;
use App\Models\SearchTerm;
use App\Repository\Products\ProductSearchRepository;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Search data from products.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $searchString = '';
        if (request()->query->get('search')) {
            $searchString = request()->query->get('search');

            SearchTerm::create([
                'user_id' => auth()->check() ? auth()->id() : null,
                'search_term' => $searchString,
            ]);
        }

        return view('e-commerce.products.search', ['searchStr' => $searchString]);
    }

    /**
     * browse by categories.
     *
     * @return void
     */
    public function browseByCategory($id)
    {
        $seoSource = Menu::find($id);

        return view('e-commerce.products.search', ['category' => $id, 'seoSource' => $seoSource]);
    }

    /**
     * browse by menu.
     *
     * @return void
     */
    public function browseByMenu($id)
    {
        $seoSource = Menu::find($id);

        return view('e-commerce.products.search', ['menu' => $id, 'seoSource' => $seoSource]);
    }

    /**
     * @return void
     */
    public function getMenus()
    {
        $menus = Menu::active()->with(['children.children.children.children'])
            ->whereNull('parent_id')
            ->get();

        // Add product count to each menu
        $menus = $menus->map(function ($menu) {
            $menu->product_count = $menu->products()->where('status', Menu::STATUS_ACTIVE)->where('is_published', Product::IS_PUBLISHED)->count();

            // Also add product count to children recursively
            if ($menu->children) {
                $menu->children = $menu->children->map(function ($child) {
                    $child->product_count = $child->products()->where('status', Menu::STATUS_ACTIVE)->where('is_published', Product::IS_PUBLISHED)->count();

                    // Add product count to grandchildren
                    if ($child->children) {
                        $child->children = $child->children->map(function ($grandchild) {
                            $grandchild->product_count = $grandchild->products()->where('status', Menu::STATUS_ACTIVE)->where('is_published', Product::IS_PUBLISHED)->count();

                            // Add product count to great-grandchildren
                            if ($grandchild->children) {
                                $grandchild->children = $grandchild->children->map(function ($greatGrandchild) {
                                    $greatGrandchild->product_count = $greatGrandchild->products()->where('status', Menu::STATUS_ACTIVE)->where('is_published', Product::IS_PUBLISHED)->count();
                                    return $greatGrandchild;
                                });
                            }

                            return $grandchild;
                        });
                    }

                    return $child;
                });
            }

            return $menu;
        });

        $ageGroups = AgeGroup::get();

        return response()->json([
            'data' => [
                'menus' => $menus,
                'age_groups' => $ageGroups,
            ]
        ]);
    }

    /**
     * Api filter
     *
     * @param Type|null $var
     *
     * @return void
     */
    public function filter(?string $searchStr = null)
    {
        $products = ProviderPricing::whereHas('product', function ($query) use ($searchStr) {
            return $query->where('name', 'like', '%' . $searchStr . '%')
                ->where('description', 'like', '%' . $searchStr . '%')
                ->where('keywords', 'like', '%' . $searchStr . '%');
        })
            ->with(['product.attachments.media', 'product.discount', 'product.colors'])
            ->groupBy('product_id')
            ->paginate(20);

        return response()->json(['data' => $products]);
    }

    /**
     * ProductSearch
     *
     * @param Request $request
     *
     * @return void
     */
    public function productSearch(ProductSearchRepository $searchRepository, Request $request)
    {
        $products = $searchRepository->search($request->all());

        return response()->json([
            'products' => $products,
        ]);
    }
}
