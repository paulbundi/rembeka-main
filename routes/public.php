<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\Ecommerce\ProductController;
use App\Http\Controllers\Ecommerce\ProviderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\ValidationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/nail-services', [ProductController::class, 'hiddenTreasure'])
    ->name('nail-services');
/*8
* Cart routes
*/
Route::post('/add-to-cart', [CartController::class, 'addtoCart'])
    ->name('cart.add');

Route::get('/remove-from-cart/{id}', [CartController::class, 'removeFromCart'])
    ->name('cart.remove');

Route::get('/checkout/cart', [CartController::class, 'checkout'])
    ->name('checkout.cart');

Route::get('/checkout/details', [CartController::class, 'checkoutDetails'])
    ->name('checkout.details');

Route::post('/checkout/store', [CartController::class, 'createAccount'])
    ->name('checkout.store');
Route::post('/order-additional-info', [CartController::class, 'additionalInformation'])
    ->name('order-additional.info');

Route::match(['get', 'post'], '/payment/method', [CartController::class, 'paymentMode'])
    ->name('payment.mode');

Route::get('validate-payment', [CartController::class, 'validateStkPayment'])
    ->name('validate.stk');

Route::match(['get', 'post'], 'complete/order', [CartController::class, 'completeOrder'])
    ->name('complete.order');

Route::post('pay-on-delivery', [CartController::class, 'PayOnDelivery'])
    ->name('pay-on.delivery');

//search routes
Route::get('/product/{slug}/{productId}', [ProductController::class, 'show'])
    ->name('product.show');

Route::get('/service/{slug}/{productId}/{provider}', [ProductController::class, 'show'])
    ->name('service.show');

Route::get('search', [SearchController::class, 'index'])
    ->name('search.index');

Route::get('filter/{searchStr?}', [SearchController::class, 'filter'])
    ->name('filter.index');

Route::get('/browse-by-categories/{id}', [SearchController::class, 'browseByCategory'])
    ->name('browse-by-categories.index');

Route::get('/browse-by-menu/{id}', [SearchController::class, 'browseByMenu'])
    ->name('browse-by-menu.index');

Route::get('get-menus', [SearchController::class, 'getMenus'])
    ->name('get.menus');

Route::get('products-search', [SearchController::class, 'productSearch'])
    ->name('products.search');

//otp
Route::get('/otp', [OtpController::class, 'index'])
    ->name('otp');

Route::post('/verify/otp', [OtpController::class, 'verify'])
    ->name('verify.otp');

Route::get('/otp-resend', [OtpController::class, 'reSendOtp'])
    ->name('otp.resend');

//locations

Route::get('/search-location/{string}', [LocationController::class, 'searchLocation'])
    ->name('search-location');

Route::get('/unzoned-locations', [LocationController::class, 'unzonedLocations'])
    ->name('unzoned.locations');

//provider/stylist
Route::get('stylists', [ProviderController::class, 'stylistsIndex'])
    ->name('stylists.index');

Route::get('stylists/{product}', [ProviderController::class, 'getStylist'])
    ->name('stylists');

Route::get('stylists/{slug}/profile', [ProviderController::class, 'stylistShow'])
    ->name('stylist.show');

Route::get('filter-stylist', [ProviderController::class, 'filterStylist'])
    ->name('filter.stylists');

// Route::get('/stylists-profile/{slug}', [ProductController::class, 'bookMyService'])
//     ->name('stylists-profile');

Route::get('stylists-inquire', [ProviderController::class, 'wantToJoin'])
    ->name('stylists.inquire');

Route::post('create-inquiries', [ProviderController::class, 'createInquiry'])
    ->name('stylist-inquiries');

Route::get('stylist-catalogue/{stylist}', [ProviderController::class, 'stylistCatalogue'])
    ->name('stylist-catalogue.show');

Route::get('stylist-rating/{stylist}', [ProviderController::class, 'stylistRatings'])
    ->name('stylist-rating.show');

//News letter
Route::post('/news-letter/subscribe', [HomeController::class, 'subscribeNewsLetter'])
    ->name('news-letter.subscribe');

//Terms and conditions.
Route::get('/terms-and-condition', [HomeController::class, 'getTermsAndCondition'])
    ->name('terms.and.condtions');
Route::get('data-privacy', [HomeController::class, 'getDataPrivacy'])
    ->name('data.privacy');

/*
 * Mpesa payment endpoints
 */
// Route::group(['middleware' => ['allowed-mpesa-ips']], function () {
    Route::any('payment_validation', [ValidationController::class , 'paymentValidation']);
    Route::any('payment_confirmation', [ValidationController::class, 'paymentConfirmation']);

    Route::any('b2c_results', [ValidationController::class, 'paymentResult']);
    Route::any('b2c_timeout', [ValidationController::class, 'transactionTimeout']);
    Route::any('invalid-stk', [ValidationController::class, 'invalidStK']);
    Route::any('status/callback', [ValidationController::class, 'statusCallback']);
    Route::post('sms/callback', [SmsController::class, 'smsCallback']);

// });

// Route::get('sync-product', function () {
//     App\Models\Order::whereHas('items', function ($query) {
//         $query->where('provider_paid', 1);
//     })
//     ->chunk(5, function ($orders) {
//         $orders->each(function ($order) {
//             $order->status = 7;
//             $order->save();
//         });
//     });
// });

// Route::get('/mask-data', function () {
//     User::chunk(10, function ($users) {
//         $users->each(function ($user) {
//             $user->email = Str::random(20).'@gmail.com';
//             $user->phone = rand(1, 5000).Str::random(10);
//             $user->save();
//         });
//     });
// });

// Route::get('/corporate-accounts', function () {
//     User::where('account_type', User::TYPE_CORPORATE)->chunk(10, function ($users) {
//         $users->each(function ($user) {
//             $user->account_no = 'C'.$user->id.'/'.\Carbon\Carbon::parse($user->created_at)->format('m/y');
//             $user->save();
//         });
//     });
// });
