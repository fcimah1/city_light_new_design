<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\PurchaseHistoryController;
use App\Http\Controllers\Website\InvoiceController;
use App\Http\Controllers\Website\WalletController;
use App\Http\Controllers\Website\AizUploadController;
use App\Http\Controllers\Website\AddressController;
use App\Http\Controllers\Website\BlogController;
use App\Http\Controllers\Website\SearchController;
use App\Http\Controllers\Website\CartController;
use App\Http\Controllers\Website\CheckoutController;
use App\Http\Controllers\Website\NotificationController;
use App\Http\Controllers\Website\LanguageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Website\CouponController;
use App\Http\Controllers\Website\WishlistController;
use App\Http\Controllers\Website\ConversationController;
use App\Http\Controllers\Website\ProductBulkUploadController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AramexController;
use App\Http\Controllers\TabbyController;
use App\Http\Controllers\TamaraController;
use App\Http\Middleware\AdminAuthenticate;
use App\Http\Middleware\AppLanguage;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUnbanned;
use App\Http\Middleware\IsUser;
use App\Http\Middleware\RedirectBasedOnCountry;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;

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

Route::middleware([RedirectBasedOnCountry::class, AppLanguage::class])->group(function () {
    Route::get('/country', function () {
        // This route will redirect based on the visitor's country

    });
    Route::get('/', [HomeController::class,'new'] )->name('home');

    Route::get('/home', [HomeController::class, 'new'])->name('home');
    Route::get('/subCategories/{category_id}', [HomeController::class,'subCategories'])->name('home.subCategories');
     // Add other routes that should redirect based on country here




    Route::get('/clear', [AdminController::class,'clearCache'])->name('cache.clear');
    Route::post('/aiz-uploader', [AizUploadController::class,'show_uploader']);
    Route::post('/aiz-uploader/upload', [AizUploadController::class,'upload']);
    Route::get('/aiz-uploader/get_uploaded_files', [AizUploadController::class,'get_uploaded_files']);
    Route::post('/aiz-uploader/get_file_by_ids', [AizUploadController::class,'get_preview_files']);
    Route::get('/aiz-uploader/download/{id}', [AizUploadController::class,'attachment_download'])->name('download_attachment');

    Route::get('/language', [LanguageController::class,'changeLanguage'])->name('language.change');



    Route::get('/about', [HomeController::class,'about'] )->name('about');
    //Route::get('/shop', [HomeController::class,'shop'] );
    //Route::get('/blog', [HomeController::class,'blog'] );
    Route::get('/contact', [HomeController::class,'contact'] )->name('contact');

    //Route::get('/cart', [HomeController::class,'cart'] );
    Route::get('/single', [HomeController::class,'single'] );
    Route::get('/checkout', [HomeController::class,'checkout'] );
    Route::get('/error', [HomeController::class,'error'] );
    Route::get('/my-account', [HomeController::class,'myAccount'] );
    Route::get('/we-offer', [HomeController::class,'weOffer'] );
    Route::get('/user', [HomeController::class,'user'] )->name('user');

    //Route::get('login',[HomeController::class,'loginV'])->name('login');
    //Route::post('register',[HomeController::class,'index'])->name('register');


    Auth::routes(['verify' => true]);
    Route::get('/logout', [LoginController::class,'logout']);
    Route::get('/email/resend', [VerificationController::class,'resend'])->name('verification.resend');
    Route::get('/verification-confirmation/{code}', [VerificationController::class,'verification_confirmation'])->name('email.verification.confirmation');
    Route::get('/email_change/callback', [HomeController::class,'email_change_callback'])->name('email_change.callback');
    Route::post('/password/reset/email/submit', [HomeController::class,'reset_password_with_code'])->name('password.update');




    //Route::post('/currency', 'CurrencyController@changeCurrency')->name('currency.change');
    //
    //Route::get('/social-login/redirect/{provider}', 'Auth\LoginController@redirectToProvider')->name('social.login');
    //Route::get('/social-login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('social.callback');

    Route::get('/users/login',  [HomeController::class,'login'])->name('user.login');
    Route::get('/users/registration',  [HomeController::class,'registration'])->name('user.registration');

    Route::post('/users/login/cart', [HomeController::class,'cart_login'])->name('cart.login.submit');


    Route::middleware([ 'user', 'unbanned'])->group( function() {
        Route::get('/dashboard', [HomeController::class,'dashboard'])->name('dashboard');
        Route::get('/profile', [HomeController::class,'profile'])->name('profile');
        Route::post('/new-user-verification', [HomeController::class,'new_verify'])->name('user.new.verify');
        Route::post('/new-user-email', [HomeController::class,'update_email'])->name('user.change.email');

        Route::post('/user/update-profile', [HomeController::class,'userProfileUpdate'])->name('user.profile.update');

        Route::get('purchase_history', [PurchaseHistoryController::class,'index'])->name('purchase_history.index');

        Route::post('/purchase_history/details', [PurchaseHistoryController::class,'purchase_history_details'])->name('purchase_history.details');

    // not finish
        Route::get('/purchase_history/destroy/{id}',  [PurchaseHistoryController::class,'destroy'])->name('purchase_history.destroy');

        Route::resource('wishlists', '\App\Http\Controllers\Website\WishlistController');
        Route::post('/wishlists/remove', [WishlistController::class,'remove'])->name('wishlists.remove');

        Route::get('/wallet', [WalletController::class,'index'])->name('wallet.index');
        Route::post('/recharge', [WalletController::class,'recharge'])->name('wallet.recharge');

        Route::post('/customer_products/status', 'CustomerProductController@updateStatus')->name('customer_products.update.status');

        Route::get('digital_purchase_history',  [PurchaseHistoryController::class,'digital_index'])->name('digital_purchase_history.index');

        Route::get('/all-notifications', [NotificationController::class,'index'])->name('all-notifications');
    });


    Route::get('/product-bulk-export', [ProductBulkUploadController::class,'export'])->name('product_bulk_export.index');

    Route::group(['middleware' => ['auth']], function() {
        Route::post('/products/store/', [ProductController::class,'store'])->name('products.store');
        Route::post('/products/update/{id}', [ProductController::class,'update'])->name('products.update');
        Route::get('/products/destroy/{id}', [ProductController::class,'destroy'])->name('products.destroy');
        Route::get('/products/duplicate/{id}', [ProductController::class,'duplicate'])->name('products.duplicate');
        Route::post('/products/sku_combination', [ProductController::class,'sku_combination'])->name('products.sku_combination');
        Route::post('/products/sku_combination_edit', [ProductController::class,'sku_combination_edit'])->name('products.sku_combination_edit');
        Route::post('/products/seller/featured', [ProductController::class,'updateSellerFeatured'])->name('products.seller.featured');
        Route::post('/products/published', [ProductController::class,'updatePublished'])->name('products.published');

        Route::post('/products/add-more-choice-option', [ProductController::class,'add_more_choice_option'])->name('products.add-more-choice-option');

        Route::get('invoice/{order_id}',[InvoiceController::class ,'invoice_download'])->name('invoice.download');

        Route::resource('orders', '\App\Http\Controllers\Admin\OrderController');
        Route::get('/orders/destroy/{id}', [OrderController::class,'destroy'])->name('orders.destroy');
        Route::post('/orders/details', [OrderController::class,'order_details'])->name('orders.details');
        Route::post('/orders/update_delivery_status', [OrderController::class,'update_delivery_status'])->name('orders.update_delivery_status');
        Route::post('/orders/update_payment_status', [OrderController::class,'update_payment_status'])->name('orders.update_payment_status');
        Route::post('/orders/delivery-boy-assign', [OrderController::class,'assign_delivery_boy'])->name('orders.delivery-boy-assign');

        Route::resource('conversations', '\App\Http\Controllers\Website\ConversationController');
        Route::get('/conversations/destroy/{id}', [ConversationController::class,'destroy'])->name('conversations.destroy');
        Route::post('conversations/refresh', [ConversationController::class,'refresh'])->name('conversations.refresh');

    Route::get('/product-csv-download/{type}', 'ProductBulkUploadController@import_product')->name('product_csv.download');

        //Category Bulk Upload by mark
        Route::get('/category-bulk-upload/index', 'CategoryBulkUploadController@index')->name('category-bulk-upload.index');
        Route::post('/bulk-category-upload', 'CategoryBulkUploadController@bulk_upload')->name('bulk_category_upload');
        Route::post('/bulk-brand-upload', 'CategoryBulkUploadController@bulk_brand_upload')->name('bulk_brand_upload');

        //Reports
        Route::get('/commission-log', 'ReportController@commission_history')->name('commission-log.index');

        //Coupon Form
        Route::post('/coupon/get_form', [CouponController::class,'get_coupon_form'])->name('coupon.get_coupon_form');
        Route::post('/coupon/get_form_edit', [CouponController::class,'get_coupon_form_edit'])->name('coupon.get_coupon_form_edit');
    });

    //Address
    Route::post('/get-states', [AddressController::class,'getStates'])->name('get-state');
    Route::post('/get-cities', [AddressController::class,'getCities'])->name('get-city');
    Route::resource('addresses', AddressController::class);
    //Route::resource('addresses', \App\Http\Controllers\Website\AddressController::class);

    Route::post('/addresses/update/{id}', [AddressController::class,'update'])->name('addresses.update');
    Route::get('/addresses/destroy/{id}', [AddressController::class,'destroy'])->name('addresses.destroy');
    Route::get('/addresses/set_default/{id}', [AddressController::class,'set_default'])->name('addresses.set_default');

    //
    //
    //Blog Section
    Route::get('/blog', [BlogController::class,'all_blog'])->name('blog');
    Route::get('/blogSearch', [BlogController::class,'search'])->name('search');
    Route::get('/blog/{slug}', [BlogController::class,'blog_details'])->name('blog.details');
    Route::get('/category_blog/{slug}', [BlogController::class,'category'])->name('categort_blog');




    Route::get('/shop', [SearchController::class,'index'])->name('shop');
    //Route::get('/search?keyword={search}', [SearchController::class,'index'])->name('suggestion.search');
    Route::get('/search', [SearchController::class,'index'])->name('suggestion.search');
    //Route::post('/search', [SearchController::class,'index'])->name('suggestion.searchs');
    Route::post('/ajax-search', [SearchController::class,'ajax_search'])->name('search.ajax');
    Route::get('/category/{category_slug}', [SearchController::class,'listingByCategory'])->name('products.category');
    Route::get('/brand/{brand_slug}', [SearchController::class,'listingByBrand'])->name('products.brand');

    Route::get('/navbar-data', [HomeController::class, 'get_count_of_cart_and_wishlist'])->name('navbar.data');


    Route::get('/product/{slug}', [HomeController::class,'product'])->name('product');
    Route::post('/product/variant_price',  [HomeController::class,'variant_price'])->name('products.variant_price');

    Route::get('/admin', [AdminController::class,'admin_dashboard'])->name('admin.dashboard')
    ->middleware([AdminAuthenticate::class, IsAdmin::class]);

    Route::get('/cart', [CartController::class,'index'])->name('cart');
    Route::post('/cart/show-cart-modal', [CartController::class,'showCartModal'])->name('cart.showCartModal');
    Route::post('/cart/addtocart', [CartController::class,'addToCart'])->name('cart.addToCart');
    Route::post('/cart/removeFromCart', [CartController::class,'removeFromCart'])->name('cart.removeFromCart');
    Route::post('/cart/updateQuantity', [CartController::class,'updateQuantity'])->name('cart.updateQuantity');
    Route::get('cart-count', [CartController::class,'cartCount'])->name('cart-count');
    Route::get('cart-total', [CartController::class,'cartTotal'])->name('cart-total');


    //Checkout Routes
    Route::group(['prefix' => 'checkout'], function() {

        Route::get('/', [CheckoutController::class,'get_shipping_info'])->name('checkout.shipping_info');
        Route::any('/delivery_info', [CheckoutController::class,'store_shipping_info'])->name('checkout.store_shipping_infostore');
        Route::post('/payment_select', [CheckoutController::class,'store_delivery_info'])->name('checkout.store_delivery_info');

        Route::get('/order-confirmed', [CheckoutController::class,'order_confirmed'])->name('order_confirmed');
        Route::post('/payment', [CheckoutController::class,'checkout'])->name('payment.checkout');
        Route::post('/get_pick_up_points',[HomeController::class,'get_pick_up_points'])->name('shipping_info.get_pick_up_points');
        Route::get('/payment-select', [CheckoutController::class,'get_payment_info'])->name('checkout.payment_info');
        Route::post('/apply_coupon_code', [CheckoutController::class,'apply_coupon_code'])->name('checkout.apply_coupon_code');
        Route::post('/remove_coupon_code', [CheckoutController::class,'remove_coupon_code'])->name('checkout.remove_coupon_code');
        //Club point
        Route::post('/apply-club-point', [CheckoutController::class,'apply_club_point'])->name('checkout.apply_club_point');
        Route::post('/remove-club-point', [CheckoutController::class,'remove_club_point'])->name('checkout.remove_club_point');
    });

    //Flash Deal Details Page
    Route::get('/flash-deals', [HomeController::class,'all_flash_deals'])->name('flash-deals');
    Route::get('/flash-deal/{slug}', [HomeController::class,'flash_deal_details'])->name('flash-deal-details');

    Route::get('/sitemap.xml', function() {
        return base_path('sitemap.xml');
    });

    Route::get('/returnpolicy', 'HomeController@returnpolicy')->name('returnpolicy');

    Route::get('stripe', [StripePaymentController::class,'stripe']);
    Route::post('/stripe/create-checkout-session', [StripePaymentController::class,'create_checkout_session'])->name('stripe.get_token');
    Route::any('/stripe/payment/callback', [StripePaymentController::class,'callback'])->name('stripe.callback');
    Route::get('/stripe/success', [StripePaymentController::class,'success'])->name('stripe.success');
    Route::get('/stripe/cancel', [StripePaymentController::class,'cancel'])->name('stripe.cancel');

    //tamara
    Route::post('tamara/chechout', [TamaraController::class,'createCheckoutSession'])->name('tamara.chechout');
    Route::get('tamara/success', [TamaraController::class,'success'])->name('tamara.success');
    Route::get('tamara/cancel', [TamaraController::class,'cancel'])->name('tamara.cancel');
    // Route::get('tamara-payment-types', [TamaraController::class,'payment_types'])->name('tamara.payment_types');
    // Route::post('tamara-payment-ckeck', [TamaraController::class,'checkoutavailablity'])->name('tamara.payment_types');
    // Route::post('tamara-order-details', [TamaraController::class,'orderDetails'])->name('tamara.chechout');


    //tabby 
    Route::post('tabby/checkout', [TabbyController::class, 'initiateCheckout'])->name('tabby.checkout');
    Route::get('/tabby/success', [TabbyController::class, 'cancel'])->name('tabby.success');
    Route::get('/tabby/cancel', [TabbyController::class, 'cancel'])->name('tabby.cancel');
    Route::get('/tabby/failure', [TabbyController::class, 'cancel'])->name('tabby.cancel');
    // Route::get('tabby/checkout/{id}', [TabbyController::class, 'getCheckoutSession'])->name('tabby.checkout.show');
    // Route::post('tabby/payments', [TabbyController::class, 'getAllPayment'])->name('tabby.getAll-payment');
    // Route::post('tabby/payments/{payment_id}/captures', [TabbyController::class, 'capturePayment'])->name('tabby.capture-payment');
    // Route::post('tabby/payments/{payment_id}', [TabbyController::class, 'retrievePayment'])->name('tabby.retrieve-payment');
    // Route::put('tabby/payments/{payment_id}', [TabbyController::class, 'updatePayment'])->name('tabby.update-payment');
    // Route::post('tabby/payments/{payment_id}/refunds', [TabbyController::class, 'refundPayment'])->name('tabby.refund-payment');
    // Route::post('tabby/payments/{payment_id}/close', [TabbyController::class, 'closePayment'])->name('tabby.close-payment');


    //aramex
    Route::post('/create-shipment', [AramexController::class, 'createShipment'])->name('create-shipment');
    Route::post('/get-shipment-details', [AramexController::class, 'getShipmentDetails'])->name('get-shipment-details');
    Route::post('/get-shipment-rate', [AramexController::class, 'getShipmentRate'])->name('get-shipment-rate');
    Route::post('/get-shipment-tracking', [AramexController::class, 'getShipmentTracking'])->name('get-shipment-tracking');
    Route::post('/get-shipment-label', [AramexController::class, 'getShipmentLabel'])->name('get-shipment-label');

    Route::get('/faqs', [HomeController::class ,'faqs'])->name('faqs');

    //Custom page not use yet
    Route::get('/{slug}', [HomeController::class ,'show_custom_page'])->name('custom-pages.show_custom_page');

});