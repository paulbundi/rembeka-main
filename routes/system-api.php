<?php

use App\Http\Controllers\Api\AdvertController;
use App\Http\Controllers\Api\AgeGroupController;
use App\Http\Controllers\Api\BestSellerController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\BtocController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ChannelController;
use App\Http\Controllers\Api\CorporateController;
use App\Http\Controllers\Api\CorporateUserController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\CtobController;
use App\Http\Controllers\Api\CustomerOrderController;
use App\Http\Controllers\Api\CustomerReviewController;
use App\Http\Controllers\Api\DeliveryRequestController;
use App\Http\Controllers\Api\DiscountedController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\EmailCampaignController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\ExpenseTypeController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\InquiryActivityController;
use App\Http\Controllers\Api\InquiryController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\MerchandiseController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\NewsLetterController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\PdqPaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductServiceController;
use App\Http\Controllers\Api\ProviderController;
use App\Http\Controllers\Api\ProviderInquiryController;
use App\Http\Controllers\Api\ProviderPricingController;
use App\Http\Controllers\Api\ProviderProfileController;
use App\Http\Controllers\Api\ReferralCodeController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SmsCampaignController;
use App\Http\Controllers\Api\StkController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\SupplierInvoiceController;
use App\Http\Controllers\Api\SupplierPricingController;
use App\Http\Controllers\Api\TransportRequestController;
use App\Http\Controllers\Api\UnitMeasureController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WalletAuditController;
use App\Http\Controllers\Api\WalletTopUpController;
use App\Http\Controllers\Api\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin vue backend api routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Route::get('/roles-permissions', [RoleController::class, 'getPermissions']);
Route::post('/roles/{role_id}/{relationName}', [RoleController::class, 'attachRelations']);
Route::delete('/roles/{role_id}/{relationName}', [RoleController::class, 'detachRelations']);
Route::post('/products/{product_id}/{relationName}', [ProductController::class, 'attachMorphRelations']);
Route::post('/services/{product_id}/{relationName}', [ProductController::class, 'attachMorphRelations']);
Route::delete('/products/{product_id}/{relationName}', [ProductController::class, 'dettachMorphRelations']);
Route::delete('/services/{product_id}/{relationName}', [ProductController::class, 'dettachMorphRelations']);
Route::delete('/providers/{product_id}/{relationName}', [ProviderController::class, 'detachRelations']);
Route::post('/groups/{id}/{relationName}', [GroupController::class, 'attachRelations']);
Route::delete('/groups/{id}/{relationName}', [GroupController::class, 'detachRelations']);
Route::delete('/provider-profiles/{attachmentId}/{relationName}', [ProviderProfileController::class, 'dettachMorphRelations']);


/*
 * users
 */
Route::post('users/{id}/{relation}', [UserController::class, 'attachRelations']);
Route::post('users/{id}/{relation}/detach', [UserController::class, 'detachRelations']);
Route::post('user-reset-password-link/{id}', [UserController::class, 'sendPasswordReset']);

/*
 * Confirm STK push
 */
Route::get('confirm-stk/{transId}', [StkController::class, 'confirmPayment']);
Route::post('validate-c2b', [CtobController::class, 'confirmPayment']);
Route::post('attach-payment-to-order', [CtobController::class, 'attachPaymentToOrder']);

/*
 * Orders
 */
Route::get('orders-ask-for-payment/{transId}', [OrderController::class, 'requestForPayment']);
Route::get('transport-request-approve/{transId}', [TransportRequestController::class, 'approveTransport']);
Route::get('transport-request-denny/{transId}', [TransportRequestController::class, 'dennyRequest']);
Route::get('delivery-request-approve/{transId}', [DeliveryRequestController::class, 'approveTransport']);
Route::get('delivery-request-denny/{transId}', [DeliveryRequestController::class, 'dennyRequest']);

Route::post('orders-confirm/{id}', [OrderController::class, 'confirmOrder']);
Route::post('add-order-items', [OrderController::class, 'addOrderItems']);
Route::post('order-wallet-payment', [OrderController::class, 'payOrderFromWallet']);
Route::get('order-re-work-payable/{id}', [OrderController::class, 'reWorkPayable']);
Route::post('order-pdq-payment', [OrderController::class, 'pdqPayment']);




/*
 * Order Items
 */
Route::get('provider-payment/{payment}', [OrderItemController::class, 'makeProviderPayment'])
    ->middleware('can-access:providers.pay-provider');

/*
 * Advert Module Groups
 */
Route::get('group-members-refresh/{id}', [GroupController::class, 'refreshMembers'])
    ->middleware('can-access:groups.update');


/*
 * Wallet
 */
Route::post('wallet-top-ups', [WalletTopUpController::class, 'store'])
    ->name('wallet-top-ups.store');
Route::post('inter-account-transfer', [WalletAuditController::class, 'accountTransfer'])
    ->name('inter-account.transfer');
/*
 * Products
 */
Route::post('supplier-receive-products', [SupplierPricingController::class, 'receiveProducts'])
    ->name('supplier-products.receive');

Route::get('btoc-reverse/{id}', [BtocController::class, 'reverseTransaction'])
    ->middleware('can-access:btoc.wallet-reversal');

/*
 * Notifications
 */
Route::resources([
    'adverts' => AdvertController::class,
    'age-groups' => AgeGroupController::class,
    'best-sellers' => BestSellerController::class,
    'brands' => BrandController::class,
    'btoc' => BtocController::class,
    'bookings' => BookingController::class,
    'categories' => CategoryController::class,
    'channels' => ChannelController::class,
    'corporate-users' => CorporateUserController::class,
    'corporates' => CorporateController::class,
    'coupons' => CouponController::class,
    'ctob' => CtobController::class,
    'drivers' => DriverController::class,
    'discounted' => DiscountedController::class,
    'expense-types' => ExpenseTypeController::class,
    'expenses' => ExpenseController::class,
    'inquiries' => InquiryController::class,
    'inquiry-activities' => InquiryActivityController::class,
    'locations' => LocationController::class,
    'medias' => MediaController::class,
    'menus' => MenuController::class,
    'merchandise' => MerchandiseController::class,
    'news-letters' => NewsLetterController::class,
    'order-items' => OrderItemController::class,
    'orders' => OrderController::class,
    'partners' => PartnerController::class,
    'pdq-payments' => PdqPaymentController::class,
    'products' => ProductController::class,
    'provider-inquiries' => ProviderInquiryController::class,
    'provider-pricings' => ProviderPricingController::class,
    'provider-profiles' => ProviderProfileController::class,
    'providers' => ProviderController::class,
    'roles' => RoleController::class,
    'sales' => SaleController::class,
    'services' => ServiceController::class,
    'stk-request' => StkController::class,
    'supplier-pricings' => SupplierPricingController::class,
    'suppliers' => SupplierController::class,
    'supplier-invoices' => SupplierInvoiceController::class,
    'transport-requests' => TransportRequestController::class,
    'delivery-requests' => DeliveryRequestController::class,
    'unit-measures' => UnitMeasureController::class,
    'users' => UserController::class,
    'wallet-audits' => WalletAuditController::class,
    'products-services' => ProductServiceController::class,
    'groups' => GroupController::class,
    'sms-campaigns ' => SmsCampaignController::class,
    'email-campaigns ' => EmailCampaignController::class,
    'wish-lists' => WishlistController::class,
    'stores' => StoreController::class,
    'reviews' => CustomerReviewController::class,
    'referrals' => ReferralCodeController::class,
    'customer-orders' => CustomerOrderController::class,

]);


