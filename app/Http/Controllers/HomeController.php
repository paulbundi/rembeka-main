<?php

namespace App\Http\Controllers;

use App\Models\BestSeller;
use App\Models\Discounted;
use App\Models\NewsLetterSubscription;
use App\Models\Partner;
use App\Models\Provider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @return void
     */
    public function index()
    {
        $bestSellers = BestSeller::inRandomOrder()
            ->with([
                'product.attachments.media',
                'product.category'
            ])
            ->limit(15)->get();

        $discounted = Discounted::inRandomOrder()
            ->with([
                'product.attachments.media',
                'product.category',
                'product.lastestProviderPricing',
            ])
            ->limit(15)->get();

        $stylists = Provider::published()->active()->paginate(50);

        $partners =  Partner::with(['logo'])->where('status', Partner::STATUS_ACTIVE)->get();

        return view('e-commerce.welcome', [
            'bestSellers' => $bestSellers,
            'discounted' => $discounted,
            'stylists' => $stylists,
            'partners' => $partners,
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
