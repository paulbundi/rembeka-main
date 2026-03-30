<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Ecommerce\AddressController;
use App\Http\Controllers\Ecommerce\BookingController;
use App\Http\Controllers\Ecommerce\DeliveryRequestController;
use App\Http\Controllers\Ecommerce\OrderController;
use App\Http\Controllers\Ecommerce\ProductReviewController;
use App\Http\Controllers\Ecommerce\ProfileController;
use App\Http\Controllers\Ecommerce\ServiceRequestController;
use App\Http\Controllers\Ecommerce\TicketController;
use App\Http\Controllers\Ecommerce\WishlistController;
use App\Http\Controllers\TransactionController;
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
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'dashboard'])
    ->name('dashboard');

Route::get('/dashboard/service', [DashboardController::class, 'serviceDashboard'])
    ->middleware(['auth', 'dashboard'])
    ->name('dashboard.service');

Route::get('/dashboard/product', [DashboardController::class, 'productDashboard'])
    ->middleware(['auth', 'dashboard'])
    ->name('dashboard.product');
    

Route::get('wishlist', [WishlistController::class, 'wishlist'])
    ->name('wishlists.index');

    //wishlist
Route::get('wishlist/add/{slug}', [WishlistController::class, 'addWishList'])
    ->name('wishlist.add');

Route::get('wishlist/remove/{slug}', [WishlistController::class, 'removeFromWishList'])
    ->name('wishlist.remove');

Route::get('complete-request/{id}', [ServiceRequestController::class, 'completeRequest'])
    ->name('service-requests.complete');

Route::get('request-transport/{id}', [ServiceRequestController::class, 'requestForTransport'])
    ->name('service-requests.request-transport');

Route::get('request-delivery/{id}', [DeliveryRequestController::class, 'requestForTransport'])
    ->name('delivery-requests.request-transport');

Route::post('service-request-rating', [ServiceRequestController::class, 'clientRating'])
    ->name('service-request.rating');

Route::post('user-password-update', [ProfileController::class, 'passwordUpdate'])
    ->name('user-password.update');

Route::get('generate-order-invoice/{id}', [OrderController::class, 'generateOrderInvoice'])
    ->name('generate-order.invoice');
// Route::get('/order-details/{id}', [OrderController::class, 'orderDetails'])
//     ->name('view-order-details');

Route::post('buy-points', [TransactionController::class, 'buyPoints'])
    ->name('buy.points');

//E-commerce-account
Route::resources([
    'profile' => ProfileController::class,
    'book-slots' => BookingController::class,
    'orders' => OrderController::class,
    'tickets' => TicketController::class,
    'addresses' => AddressController::class,
    'product-review' => ProductReviewController::class,
    'service-requests' => ServiceRequestController::class,
    'delivery-requests' => DeliveryRequestController::class,
]);
