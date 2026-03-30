<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProviderInquiryFormRequest;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Provider;
use App\Models\ProviderInquiry;
use App\Models\ProviderPricing;
use App\Models\Rating;
use App\Repository\Providers\ProviderSearchRepository;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    /**
     * Index for providers/stylists.
     *
     * @return void
     */
    public function stylistsIndex()
    {
        $stylists =  Provider::active()
            ->with(['profile.attachments.media'])
            ->paginate();

        return view('e-commerce.stylists.index', ['stylists' => $stylists]);
    }

    /**
     * Provider/stylist Show.
     *
     * @return void
     */
    public function stylistShow(string $slug)
    {
        $stylist =  Provider::active()
            ->with(['profile.attachments.media'])
            ->where('slug', $slug)
            ->first();

        return view('e-commerce.stylists.show', [
            'stylist' => $stylist,
        ]);
    }

    /**
     * @param int $stylist
     *
     * @return void
     */
    public function stylistCatalogue(int $stylist)
    {
        $services = ProviderPricing::where('provider_id', $stylist)
            ->with(['product.attachments.media', 'product.discount'])
            ->paginate();

        return response()->json(['data' => $services]);
    }

    /**
     * Customer reviews.
     *
     * @param int $stylist
     *
     * @return void
     */
    public function stylistRatings(int $stylistId)
    {
        $ratings = Rating::whereHasMorph(
            'rateable',
            [Order::class],
            function ($query) use ($stylistId) {
                $query->whereHas('items', function ($q) use ($stylistId) {
                    $q->where('provider_id', $stylistId)
                        ->where('type', OrderItem::TYPE_SERVICE);
                });
            })
            ->with(['user'])
            ->paginate(20);

        return response()->json(['data' =>$ratings]);
    }

    /**
     * search stylist/provider.
     *
     * @param ProviderSearchRepository $searchRepository
     * @param Request                  $request
     *
     * @return void
     */
    public function getStylist(int $productId, ProviderSearchRepository $searchRepository, Request $request)
    {
        $stylist =  $searchRepository->search($productId, $request->all());

        return response()->json([
            'data' => $stylist,
        ]);
    }

    /**
     * search stylist/provider.
     *
     * @param ProviderSearchRepository $searchRepository
     * @param Request                  $request
     *
     * @return void
     */
    public function filterStylist(ProviderSearchRepository $searchRepository, Request $request)
    {
        $data =  $request->all();
        $stylist =  $searchRepository->search($data['productId'], $data);

        return response()->json([
            'data' => $stylist,
        ]);
    }

    /**
     * Provider Inquiries
     *
     * @return void
     */
    public function wantToJoin()
    {
        $menus = Menu::active()
        ->with(['children.children.children.children'])
        ->whereNull('parent_id')
        ->get();

        return view('e-commerce.stylists.inquire', ['menus' => $menus]);
    }

    /**
     * create inquiry from providers.
     *
     * @param ProviderInquiryFormRequest $request
     *
     * @return void
     */
    public function createInquiry(ProviderInquiryFormRequest $request)
    {
        $data =  $request->validated();

        ProviderInquiry::create($data);

        return redirect()->route('stylists.inquire')->with('success', 'Inquiry created');
    }
}
