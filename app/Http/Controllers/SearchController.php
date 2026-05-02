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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function browseByCategory($id)
    {
        $seoSource = Menu::find($id);

        return view('e-commerce.products.search', ['category' => $id, 'seoSource' => $seoSource]);
    }

    /**
     * browse by menu.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function browseByMenu($id)
    {
        $seoSource = Menu::find($id);

        return view('e-commerce.products.search', ['menu' => $id, 'seoSource' => $seoSource]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMenus()
    {
        // Get the menus with their nested children
        $menus = Menu::active()->with(['children.children.children.children'])
            ->whereNull('parent_id')
            ->get();

        // Create a copy of the menus data with product counts added
        // This avoids modifying the original relationships which was causing issues
        $menusWithCounts = $menus->map(function ($menu) {
            // Get product count for this menu
            $productCount = $menu->products()
                ->where('status', Menu::STATUS_ACTIVE)
                ->where('is_published', Product::IS_PUBLISHED)
                ->count();

            // Create a new array with the menu data plus product count
            $menuData = $menu->toArray();
            $menuData['product_count'] = $productCount;

            // Process children recursively
            if (!empty($menuData['children'])) {
                $menuData['children'] = array_map(function ($child) use ($menu) {
                    // Get product count for this child
                    $childProductCount = $child->products()
                        ->where('status', Menu::STATUS_ACTIVE)
                        ->where('is_published', Product::IS_PUBLISHED)
                        ->count();

                    // Create child data with product count
                    $childData = $child->toArray();
                    $childData['product_count'] = $childProductCount;

                    // Process grandchildren
                    if (!empty($childData['children'])) {
                        $childData['children'] = array_map(function ($grandchild) use ($child) {
                            // Get product count for this grandchild
                            $grandchildProductCount = $grandchild->products()
                                ->where('status', Menu::STATUS_ACTIVE)
                                ->where('is_published', Product::IS_PUBLISHED)
                                ->count();

                            // Create grandchild data with product count
                            $grandchildData = $grandchild->toArray();
                            $grandchildData['product_count'] = $grandchildProductCount;

                            // Process great-grandchildren
                            if (!empty($grandchildData['children'])) {
                                $grandchildData['children'] = array_map(function ($greatGrandchild) use ($grandchild) {
                                    // Get product count for this great-grandchild
                                    $greatGrandchildProductCount = $greatGrandchild->products()
                                        ->where('status', Menu::STATUS_ACTIVE)
                                        ->where('is_published', Product::IS_PUBLISHED)
                                        ->count();

                                    // Create great-grandchild data with product count
                                    $greatGrandchildData = $greatGrandchild->toArray();
                                    $greatGrandchildData['product_count'] = $greatGrandchildProductCount;

                                    return $greatGrandchildData;
                                }, $grandchildData['children']);
                            }

                            return $grandchildData;
                        }, $childData['children']);
                    }

                    return $childData;
                }, $menuData['children']);
            }

            return $menuData;
        });

        $ageGroups = AgeGroup::get();

        return response()->json([
            'data' => [
                'menus' => $menusWithCounts,
                'age_groups' => $ageGroups,
            ]
        ]);
    }

    /**
     * Api filter
     *
     * @param string|null $searchStr
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(?string $searchStr = null)
    {
        $products = ProviderPricing::whereHas('product', function ($query) use ($searchStr) {
            return $query->where('name', 'like', '%' . $searchStr . '%')
                ->where('description', 'like', '%' . $searchStr . '%')
                ->where('keywords', 'like', '%' . $searchStr . '%');
        })
            ->with(['product.attachments.media', 'product.discount'])
            ->groupBy('product_id')
            ->paginate(20);

        return response()->json(['data' => $products]);
    }

    /**
     * ProductSearch
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function productSearch(ProductSearchRepository $searchRepository, Request $request)
    {
        $products = $searchRepository->search($request->all());

        return response()->json([
            'products' => $products,
        ]);
    }
}
