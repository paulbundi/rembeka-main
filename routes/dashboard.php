<?php

use App\Http\Controllers\AdvertController;
use App\Http\Controllers\AgeGroupController;
use App\Http\Controllers\BestSellerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BtoCController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\CorporateController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CtoBController;
use App\Http\Controllers\DeliveryRequestController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseTypeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDiscountController;
use App\Http\Controllers\ProductPricingController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ProviderInquiryController;
use App\Http\Controllers\ProviderPricingController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceDiscountController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\StkController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransportRequestController;
use App\Http\Controllers\UnitMeasureController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletAuditController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
 * Media / Attachments
 */
Route::post('media-upload', [MediaController::class, 'uploadMedia']);

/*
 * Menus
 */

 Route::get('generate-qr-code/{id}', [MenuController::class, 'generateQrCode'])
    ->name('generate.qr-code');

/*
 * Notifications
 */
Route::get('notifications', [UserController::class, 'getNotifications'])
    ->name('notifications');

/*
 * products
 */

 Route::get('bulk-update', [ProductController::class, 'getBulkUpdateView'])
    ->name('bulk-update.merchandise');

Route::post('update-merchandise', [ProductController::class, 'bulkUpdate'])
    ->name('merchandise.bulk-update');

Route::get('import-products', [ProductController::class, 'getProductImportView'])
    ->name('import-products.index');

Route::post('products-import', [ProductController::class, 'importProducts'])
    ->name('products.import');

Route::post('products-import-update', [ProductController::class, 'importProductUpdates'])
    ->name('products.import-update');

Route::get('receive-supplier-products', [ProductController::class, 'receiveSupplierProducts'])
    ->name('supplier-products.receive');

/*
 * Orders
 */
Route::get('system-orders/{id}/invoice', [OrderController::class, 'generateInvoice'])
    ->name('system-orders.invoice');

/*
 * Stylist Income
 */
Route::get('stylist-income/{id}', [ProviderController::class, 'stylistIncome'])
    ->name('stylist.income');

Route::get('supplier-income/{id}', [SupplierController::class, 'supplierIncome'])
    ->name('supplier.income');

Route::get('transaction-history/{id}', [TransactionController::class, 'walletLog'])
    ->name('transaction-history.log');

Route::post('wallet-withdraw', [TransactionController::class, 'withdrawToMpesa'])
    ->name('wallet.withdraw')
    ->block();

Route::post('withdraw-for-provider', [TransactionController::class, 'withdrawForProvider'])
    ->name('withdraw-for-provider')
    ->block();

/*
 * Impersonate.
 */
Route::get('/users/{user}/impersonate', [UserController::class, 'impersonate'])
    ->name('users-impersonate')
    ->middleware('can-access:users.impersonate');

Route::get('/users/impersonate/exit', [UserController::class, 'exitImpersonation'])
    ->name('users-exit-impersonate');

/*
 *calendar
 */
Route::get('/calendar/index', CalendarController::class)
    ->name('calendar.index');

/*
 *calendar
 */
Route::get('/corporate-orders/create', [OrderController::class, 'createCorporateOrders'])
    ->name('corporate-orders.create');

/*
 *Campaigns
 */
Route::get('/ads', [AdvertController::class, 'index'])
    ->name('ads.index');

Route::get('/sms-campaigns', [SmsController::class, 'index'])
    ->name('sms-campaigns');
Route::get('/email-campaigns', [EmailController::class, 'index'])
    ->name('email-campaigns');
/*
 * Customer feedback
 */

Route::get('cutomer-review', [ProductReviewController::class, 'index'])
    ->name('customer-reviews.index');


/*
* Generate site map.
*/

Route::get('site-map', [ProductController::class, 'generateSiteMap'])
    ->name('generate.sitemap');


/*
 * Resources
 */
Route::resources([
    'age-groups' => AgeGroupController::class,
    'wallet-audit' => WalletAuditController::class,
    'best-sellers' => BestSellerController::class,
    'brands' => BrandController::class,
    'btoc' => BtoCController::class,
    'categories' => CategoryController::class,
    'channels' => ChannelController::class,
    'coupons' => CouponController::class,
    'corporates' => CorporateController::class,
    'inquiries' => InquiryController::class,
    'ctob' => CtoBController::class,
    'drivers' => DriverController::class,
    'franchises' => StoreController::class,
    'stk-push' => StkController::class,
    'service-discounts' => ServiceDiscountController::class,
    'product-discounts' => ProductDiscountController::class,
    'expenses' => ExpenseController::class,
    'expense-types' => ExpenseTypeController::class,
    'locations' => LocationController::class,
    'medias' => MediaController::class,
    'menus' => MenuController::class,
    'partners' => PartnerController::class,
    'services' => ServiceController::class,
    'products' => ProductController::class,
    'product-pricings' => ProductPricingController::class,
    'service-pricings'=> ProviderPricingController::class,
    'providers-inquiries' => ProviderInquiryController::class,
    'providers' => ProviderController::class,
    'suppliers' => SupplierController::class,
    'referrals' => ReferralController::class,
    'revenues' => RevenueController::class,
    'roles' => RoleController::class,
    'sales' => SaleController::class,
    'system-orders' => OrderController::class,
    'users' => UserController::class,
    'news-letter' => NewsLetterController::class,
    'transport-requests' => TransportRequestController::class,
    'product-delivery-requests' => DeliveryRequestController::class,
    'unit-measures' => UnitMeasureController::class,
    'groups' => GroupController::class,
    'wish-list' => WishlistController::class,
]);
