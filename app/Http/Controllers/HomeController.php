<?php

namespace App\Http\Controllers;

use App\Models\BestSeller;
use App\Models\Brand;
use App\Models\Discounted;
use App\Models\NewsLetterSubscription;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Provider;
use App\Models\ProviderPricing;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @return void
     */
    public function index()
    {
        $bestSellers = BestSeller::inRandomOrder()
            ->whereHas('providerPricing.product.attachments.media')
            ->with([
                'providerPricing.product.attachments.media',
                'providerPricing.product.category'
            ])
            ->limit(15)->get();

        $adornBrand = Brand::whereRaw('UPPER(name) = ?', ['ADORN'])->first();
        $adornProducts = $adornBrand
            ? ProviderPricing::whereHas('product', function ($q) use ($adornBrand) {
                $q->where('brand_id', $adornBrand->id)
                  ->where('status', Product::STATUS_ACTIVE)
                  ->where('is_published', Product::IS_PUBLISHED);
            })
            ->whereHas('product.attachments.media')
            ->with(['product.attachments.media', 'product.category'])
            ->inRandomOrder()
            ->limit(10)
            ->get()
            : collect();

        $discounted = Discounted::inRandomOrder()
            ->whereHas('product.attachments.media')
            ->with([
                'product.attachments.media',
                'product.category',
                'product.lastestProviderPricing',
            ])
            ->limit(15)->get();

        $partners = Partner::whereHas('logo')
            ->with(['logo'])
            ->where('status', Partner::STATUS_ACTIVE)
            ->get();

        $stylists = Provider::whereHas('profile.attachments.media')
            ->with(['profile.attachments.media'])
            ->where('status', Provider::STATUS_ACTIVE)
            ->inRandomOrder()
            ->limit(8)
            ->get();

        return view('e-commerce.welcome', [
            'bestSellers' => $bestSellers,
            'adornProducts' => $adornProducts,
            'discounted'  => $discounted,
            'partners'    => $partners,
            'stylists'    => $stylists,
        ]);
    }

    /**
     * Subscribe to news letter.
     *
     * @param Request $request
     *
     * @return void
     */
    public function subscribeNewsLetter(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
        ]);

        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }
        NewsLetterSubscription::firstOrCreate($data);

        return redirect()->route('home')->with('goodies', 'goodies');
    }

    /**
     * Terms and conditions
     *
     * @return void
     */
    public function getTermsAndCondition()
    {
        return view('e-commerce.terms.terms-and-condition');
    }

    /**
     * Data privacy
     *
     * @return void
     */
    public function getDataPrivacy()
    {
        return view('e-commerce.terms.data-privacy');
    }
}
