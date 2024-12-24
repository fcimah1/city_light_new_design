<?php

/*
  |--------------------------------------------------------------------------
  | Admin Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register admin routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AddonController;
use App\Http\Controllers\Admin\AdsController;
use App\Http\Controllers\Admin\AizUploadController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\BusinessSettingsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\WebsiteController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\FlashDealController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CommissionController;
use App\Http\Controllers\Admin\PickupPointController;
use App\Http\Controllers\Admin\CustomerPackageController;
use App\Http\Controllers\Admin\CustomerProductController;
use App\Http\Controllers\Admin\CustomerBulkUploadController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Website\ConversationController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ShippingCompanyController;
use App\Http\Controllers\Admin\SocialMediaController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Middleware\AdminAuthenticate;
use App\Http\Middleware\IsAdmin;

 Route::get('/cache-cache', [AdminController::class,'clearCache'])->name('cache.clear');

//Route::post('/update', 'UpdateController@step0')->name('update');
//Route::get('/update/step1', 'UpdateController@step1')->name('update.step1');
//Route::get('/update/step2', 'UpdateController@step2')->name('update.step2');
Route::get('/admin/login',  [HomeController::class,'loginV'])->name('admin.login');
Route::post('/admin/login',  [HomeController::class,'adminLogin'])->name('admin.login');

Route::get('/admin', [AdminController::class,'admin_dashboard'])
    ->name('admin.dashboard')
    ->middleware([AdminAuthenticate::class, 'admin']);
Route::group(['prefix' => 'admin', 'middleware' => [AdminAuthenticate::class, IsAdmin::class]], function() {
    //Update Routes

    Route::resource('categories', '\App\Http\Controllers\Admin\CategoryController');
    Route::get('/categories/edit/{id}', [CategoryController::class,'edit'])->name('categories.edit');
    Route::get('/categories/destroy/{id}', [CategoryController::class,'destroy'])->name('categories.destroy');
    Route::post('/categories/featured', [CategoryController::class,'updateFeatured'])->name('categories.featured');

    Route::resource('brands', '\App\Http\Controllers\Admin\BrandController');
    Route::get('/brands/edit/{id}', [BrandController::class,'edit'])->name('brands.edit');
    Route::get('/brands/destroy/{id}', [BrandController::class,'destroy'])->name('brands.destroy');

    Route::get('/products/admin', [ProductController::class,'admin_products'])->name('products.admin');
    Route::get('/products/seller', [ProductController::class,'seller_products'])->name('products.seller');
    Route::get('/products/all', [ProductController::class,'all_products'])->name('products.all');
    Route::get('/products/create', [ProductController::class,'create'])->name('products.create');
    Route::get('/products/admin/{id}/edit', [ProductController::class,'admin_product_edit'])->name('products.admin.edit');
    Route::get('/products/seller/{id}/edit', [ProductController::class,'seller_product_edit'])->name('products.seller.edit');
    Route::post('/products/todays_deal', [ProductController::class,'updateTodaysDeal'])->name('products.todays_deal');
    Route::post('/products/featured', [ProductController::class,'updateFeatured'])->name('products.featured');
    Route::post('/products/best', [ProductController::class,'updateBest'])->name('products.best');
    Route::post('/products/approved', [ProductController::class,'updateProductApproval'])->name('products.approved');
    Route::post('/products/get_products_by_subcategory', [ProductController::class,'get_products_by_subcategory'])->name('products.get_products_by_subcategory');
    Route::post('/bulk-product-delete', [ProductController::class,'bulk_product_delete'])->name('bulk-product-delete');



//    Route::resource('sellers', 'SellerController');
//    Route::get('sellers_ban/{id}', 'SellerController@ban')->name('sellers.ban');
//    Route::get('/sellers/destroy/{id}', 'SellerController@destroy')->name('sellers.destroy');
//    Route::post('/bulk-seller-delete', 'SellerController@bulk_seller_delete')->name('bulk-seller-delete');
//    Route::get('/sellers/view/{id}/verification', 'SellerController@show_verification_request')->name('sellers.show_verification_request');
//    Route::get('/sellers/approve/{id}', 'SellerController@approve_seller')->name('sellers.approve');
//    Route::get('/sellers/reject/{id}', 'SellerController@reject_seller')->name('sellers.reject');
//    Route::get('/sellers/login/{id}', 'SellerController@login')->name('sellers.login');
//    Route::post('/sellers/payment_modal', 'SellerController@payment_modal')->name('sellers.payment_modal');
//    Route::get('/seller/payments', 'PaymentController@payment_histories')->name('sellers.payment_histories');
//    Route::get('/seller/payments/show/{id}', 'PaymentController@show')->name('sellers.payment_history');

    Route::resource('customers', '\App\Http\Controllers\Admin\CustomerController');
    Route::get('customers_ban/{customer}', [CustomerController::class,'ban'])->name('customers.ban');
    Route::get('/customers/login/{id}', [CustomerController::class,'login'])->name('customers.login');
    Route::get('/customers/destroy/{id}', [CustomerController::class,'destroy'])->name('customers.destroy');
    Route::post('/bulk-customer-delete', [CustomerController::class,'bulk_customer_delete'])->name('bulk-customer-delete');

    Route::get('/newsletter', [NewsletterController::class,'index'])->name('newsletters.index');
    Route::post('/newsletter/send', [NewsletterController::class,'send'])->name('newsletters.send');
    Route::post('/newsletter/test/smtp', [NewsletterController::class,'testEmail'])->name('test.smtp');

    Route::resource('profile', '\App\Http\Controllers\Admin\ProfileController');

    Route::post('/business-settings/update', [BusinessSettingsController::class,'update'])->name('business_settings.update');
    Route::post('/business-settings/update/activation', [BusinessSettingsController::class,'updateActivationSettings'])->name('business_settings.update.activation');
    Route::get('/general-setting', [BusinessSettingsController::class,'general_setting'])->name('general_setting.index');
    Route::get('/activation', [BusinessSettingsController::class,'activation'])->name('activation.index');
    Route::get('/payment-method', [BusinessSettingsController::class,'payment_method'])->name('payment_method.index');
    Route::get('/file_system', [BusinessSettingsController::class,'file_system'])->name('file_system.index');
    Route::get('/social-login', [BusinessSettingsController::class,'social_login'])->name('social_login.index');
    Route::get('/smtp-settings', [BusinessSettingsController::class,'smtp_settings'])->name('smtp_settings.index');
    Route::get('/google-analytics', [BusinessSettingsController::class,'google_analytics'])->name('google_analytics.index');
    Route::get('/google-recaptcha', [BusinessSettingsController::class,'google_recaptcha'])->name('google_recaptcha.index');
    Route::get('/google-map', [BusinessSettingsController::class,'google_map'])->name('google-map.index');
    Route::get('/google-firebase', [BusinessSettingsController::class,'google_firebase'])->name('google-firebase.index');

    //Facebook Settings
    Route::get('/facebook-chat', [BusinessSettingsController::class,'facebook_chat'])->name('facebook_chat.index');
    Route::post('/facebook_chat', [BusinessSettingsController::class,'facebook_chat_update'])->name('facebook_chat.update');
    Route::get('/faceb]ook-comment', [BusinessSettingsController::class,'facebook_comment'])->name('facebook-comment');
    Route::post('/facebook-comment', [BusinessSettingsController::class,'facebook_comment_update'])->name('facebook-comment.update');
    Route::post('/facebook_pixel', [BusinessSettingsController::class,'facebook_pixel_update'])->name('facebook_pixel.update');

    Route::post('/env_key_update', [BusinessSettingsController::class,'env_key_update'])->name('env_key_update.update');
    Route::post('/payment_method_update', [BusinessSettingsController::class,'payment_method_update'])->name('payment_method.update');
    Route::post('/google_analytics', [BusinessSettingsController::class,'google_analytics_update'])->name('google_analytics.update');
    Route::post('/google_recaptcha', [BusinessSettingsController::class,'google_recaptcha_update'])->name('google_recaptcha.update');
    Route::post('/google-map', [BusinessSettingsController::class,'google_map_update'])->name('google-map.update');
    Route::post('/google-firebase', [BusinessSettingsController::class,'google_firebase_update'])->name('google-firebase.update');
    //Currency
    Route::get('/currency', [CurrencyController::class,'currency'])->name('currency.index');
    Route::post('/currency/update', [CurrencyController::class,'updateCurrency'])->name('currency.update');
    Route::post('/your-currency/update', [CurrencyController::class,'updateYourCurrency'])->name('your_currency.update');
    Route::get('/currency/create', [CurrencyController::class,'create'])->name('currency.create');
    Route::post('/currency/store', [CurrencyController::class,'store'])->name('currency.store');
    Route::post('/currency/currency_edit', [CurrencyController::class,'edit'])->name('currency.edit');
    Route::post('/currency/update_status', [CurrencyController::class,'update_status'])->name('currency.update_status');

    //Tax
    Route::resource('tax', '\App\Http\Controllers\Admin\TaxController');
    Route::get('/tax/edit/{id}', [TaxController::class,'edit'])->name('tax.edit');
    Route::get('/tax/destroy/{id}', [TaxController::class,'destroy'])->name('tax.destroy');
    Route::post('tax-status', [TaxController::class,'change_tax_status'])->name('taxes.tax-status');


    Route::get('/verification/form', [BusinessSettingsController::class,'seller_verification_form'])->name('seller_verification_form.index');
    Route::post('/verification/form', [BusinessSettingsController::class,'seller_verification_form_update'])->name('seller_verification_form.update');
    Route::get('/vendor_commission', [BusinessSettingsController::class,'vendor_commission'])->name('business_settings.vendor_commission');
    Route::post('/vendor_commission_update', [BusinessSettingsController::class,'vendor_commission_update'])->name('business_settings.vendor_commission.update');

    Route::resource('/languages', '\App\Http\Controllers\Admin\LanguageController');
    Route::post('/languages/{id}/update', [LanguageController::class,'update'])->name('languages.update');
    Route::get('/languages/destroy/{id}', [LanguageController::class,'destroy'])->name('languages.destroy');
    Route::post('/languages/update_rtl_status', [LanguageController::class,'update_rtl_status'])->name('languages.update_rtl_status');
    Route::post('/languages/key_value_store', [LanguageController::class,'key_value_store'])->name('languages.key_value_store');

    //App Trasnlation
    Route::post('/languages/app-translations/import', [LanguageController::class,'importEnglishFile'])->name('app-translations.import');
    Route::get('/languages/app-translations/show/{id}', [LanguageController::class,'showAppTranlsationView'])->name('app-translations.show');
    Route::post('/languages/app-translations/key_value_store', [LanguageController::class,'storeAppTranlsation'])->name('app-translations.store');
    Route::get('/languages/app-translations/export/{id}', [LanguageController::class,'exportARBFile'])->name('app-translations.export');

    // website setting
    Route::group(['prefix' => 'website'], function() {
        Route::get('/footer', [WebsiteController::class,'footer'])->name('website.footer');
        Route::get('/header', [WebsiteController::class,'header'])->name('website.header');
        Route::get('/appearance', [WebsiteController::class,'appearance'])->name('website.appearance');
        Route::get('/pages', [WebsiteController::class,'pages'])->name('website.pages');


        //page
        Route::resource('custom-pages', '\App\Http\Controllers\Admin\PageController');
        Route::get('/custom-pages/edit/{id}', [PageController::class,'edit'])->name('custom-pages.edit');
        Route::get('/custom-pages/destroy/{id}', [PageController::class,'destroy'])->name('custom-pages.destroy');
    });

    Route::resource('roles', '\App\Http\Controllers\Admin\RoleController');
    Route::get('/roles/edit/{id}', [RoleController::class,'edit'])->name('roles.edit');
    Route::get('/roles/destroy/{id}', [RoleController::class,'destroy'])->name('roles.destroy');

    Route::resource('staffs', '\App\Http\Controllers\Admin\StaffController');
    Route::get('/staffs/destroy/{id}', [StaffController::class,'destroy'])->name('staffs.destroy');

    Route::resource('flash_deals', '\App\Http\Controllers\Admin\FlashDealController');
    Route::get('/flash_deals/edit/{id}', [FlashDealController::class,'edit'])->name('flash_deals.edit');
    Route::get('/flash_deals/destroy/{id}', [FlashDealController::class,'destroy'])->name('flash_deals.destroy');
    Route::post('/flash_deals/update_status', [FlashDealController::class,'update_status'])->name('flash_deals.update_status');
    Route::post('/flash_deals/update_featured', [FlashDealController::class,'update_featured'])->name('flash_deals.update_featured');
    Route::post('/flash_deals/product_discount', [FlashDealController::class,'product_discount'])->name('flash_deals.product_discount');
    Route::post('/flash_deals/product_discount_edit', [FlashDealController::class,'product_discount_edit'])->name('flash_deals.product_discount_edit');

    //Subscribersa
    Route::get('/subscribers', [SubscriberController::class,'index'])->name('subscribers.index');
    Route::get('/subscribers/destroy/{id}', [SubscriberController::class,'destroy'])->name('subscriber.destroy');


    // All Orders
    Route::get('/all_orders', [OrderController::class,'all_orders'])->name('all_orders.index');
    Route::get('/all_orders/{id}/show', [OrderController::class,'all_orders_show'])->name('all_orders.show');

    // Inhouse Orders
    Route::get('/inhouse-orders', [OrderController::class,'admin_orders'])->name('inhouse_orders.index');
    Route::get('/inhouse-orders/{id}/show', [OrderController::class,'show'])->name('inhouse_orders.show');

    // Seller Orders
    Route::get('/seller_orders', [OrderController::class,'seller_orders'])->name('seller_orders.index');
    Route::get('/seller_orders/{id}/show', [OrderController::class,'seller_orders_show'])->name('seller_orders.show');

    Route::post('/bulk-order-status', [OrderController::class,'bulk_order_status'])->name('bulk-order-status');


    // Pickup point orders
    Route::get('orders_by_pickup_point', [OrderController::class,'pickup_point_order_index'])->name('pick_up_point.order_index');
    Route::get('/orders_by_pickup_point/{id}/show', [OrderController::class,'pickup_point_order_sales_show'])->name('pick_up_point.order_show');

    Route::get('/orders/destroy/{id}', [OrderController::class,'destroy'])->name('orders.destroy');
    Route::post('/bulk-order-delete', [OrderController::class,'bulk_order_delete'])->name('bulk-order-delete');

    Route::post('/pay_to_seller', [CommissionController::class,'pay_to_seller'])->name('commissions.pay_to_seller');

    //Reports
    Route::get('/stock_report', [ReportController::class,'stock_report'])->name('stock_report.index');
    Route::get('/in_house_sale_report', [ReportController::class,'in_house_sale_report'])->name('in_house_sale_report.index');
    Route::get('/seller_sale_report', [ReportController::class,'seller_sale_report'])->name('seller_sale_report.index');
    Route::get('/wish_report', [ReportController::class,'wish_report'])->name('wish_report.index');
    Route::get('/user_search_report', [ReportController::class,'user_search_report'])->name('user_search_report.index');
    Route::get('/wallet-history', [ReportController::class,'wallet_transaction_history'])->name('wallet-history.index');

    //Blog Section
    Route::resource('blog-category', '\App\Http\Controllers\Admin\BlogCategoryController');
    Route::get('/blog-category/destroy/{id}', [BlogCategoryController::class,'destroy'])->name('blog-category.destroy');
    Route::resource('blog', '\App\Http\Controllers\Admin\BlogController');
    Route::get('/blog/destroy/{id}', [BlogController::class,'destroy'])->name('blog.destroy');
    Route::post('/blog/change-status', [BlogController::class,'change_status'])->name('blog.change-status');

    //Coupons
    Route::resource('coupon', '\App\Http\Controllers\Admin\CouponController');
    Route::get('/coupon/destroy/{id}', [CommissionController::class,'destroy'])->name('coupon.destroy');

    //Reviews
    Route::get('/reviews', 'ReviewController@index')->name('reviews.index');
    Route::post('/reviews/published', 'ReviewController@updatePublished')->name('reviews.published');

    //Support_Ticket
    Route::get('support_ticket/', 'SupportTicketController@admin_index')->name('support_ticket.admin_index');
    Route::get('support_ticket/{id}/show', 'SupportTicketController@admin_show')->name('support_ticket.admin_show');
    Route::post('support_ticket/reply', 'SupportTicketController@admin_store')->name('support_ticket.admin_store');

    //Pickup_Points
    Route::resource('pick_up_points', '\App\Http\Controllers\Admin\PickupPointController');
    Route::get('/pick_up_points/edit/{id}', [PickupPointController::class,'edit'])->name('pick_up_points.edit');
    Route::get('/pick_up_points/destroy/{id}', [PickupPointController::class,'destroy'])->name('pick_up_points.destroy');

    //conversation of seller customer
    Route::get('conversations', [ConversationController::class,'admin_index'])->name('conversations.admin_index');
    Route::get('conversations/{id}/show', [ConversationController::class,'admin_show'])->name('conversations.admin_show');

    Route::post('/sellers/profile_modal', 'SellerController@profile_modal')->name('sellers.profile_modal');
    Route::post('/sellers/approved', 'SellerController@updateApproved')->name('sellers.approved');

    Route::resource('attributes', 'AttributeController');
    Route::get('/attributes/edit/{id}', 'AttributeController@edit')->name('attributes.edit');
    Route::get('/attributes/destroy/{id}', 'AttributeController@destroy')->name('attributes.destroy');

    //Attribute Value
    Route::post('/store-attribute-value', 'AttributeController@store_attribute_value')->name('store-attribute-value');
    Route::get('/edit-attribute-value/{id}', 'AttributeController@edit_attribute_value')->name('edit-attribute-value');
    Route::post('/update-attribute-value/{id}', 'AttributeController@update_attribute_value')->name('update-attribute-value');
    Route::get('/destroy-attribute-value/{id}', 'AttributeController@destroy_attribute_value')->name('destroy-attribute-value');

    //Colors
    Route::get('/colors', 'AttributeController@colors')->name('colors');
    Route::post('/colors/store', 'AttributeController@store_color')->name('colors.store');
    Route::get('/colors/edit/{id}', 'AttributeController@edit_color')->name('colors.edit');
    Route::post('/colors/update/{id}', 'AttributeController@update_color')->name('colors.update');
    Route::get('/colors/destroy/{id}', 'AttributeController@destroy_color')->name('colors.destroy');

    Route::resource('addons', '\App\Http\Controllers\Admin\AddonController');
    Route::post('/addons/activation', [AddonController::class,'ctivation'])->name('addons.activation');

    Route::get('/customer-bulk-upload/index', [CustomerBulkUploadController::class,'index'])->name('customer_bulk_upload.index');
    Route::post('/bulk-user-upload', [CustomerBulkUploadController::class,'user_bulk_upload'])->name('bulk_user_upload');
    Route::post('/bulk-customer-upload', [CustomerBulkUploadController::class,'customer_bulk_file'])->name('bulk_customer_upload');
    Route::get('/user', [CustomerBulkUploadController::class,'pdf_download_user'])->name('pdf.download_user');
    //Customer Package

    Route::resource('customer_packages', '\App\Http\Controllers\Admin\CustomerPackageController');
    Route::get('/customer_packages/edit/{id}', [CustomerPackageController::class,'edit'])->name('customer_packages.edit');
    Route::get('/customer_packages/destroy/{id}', [CustomerPackageController::class,'destroy'])->name('customer_packages.destroy');

    //Classified Products
    Route::get('/classified_products', [CustomerProductController::class,'customer_product_index'])->name('classified_products');
    Route::post('/classified_products/published', [CustomerProductController::class,'updatePublished'])->name('classified_products.published');

    //Shipping Configuration
    Route::get('/shipping_configuration', [BusinessSettingsController::class,'shipping_configuration'])->name('shipping_configuration.index');
    Route::post('/shipping_configuration/update', [BusinessSettingsController::class,'shipping_configuration_update'])->name('shipping_configuration.update');

    //by Mohamed Ahmed

    //subCategories
    Route::get('/subcategories', [SubCategoryController::class, 'index'])->name('subcategories.index');
    Route::get('/subcategories/create', [SubCategoryController::class, 'create'])->name('subcategories.create');
    Route::post('/subcategories/store', [SubCategoryController::class, 'store'])->name('subcategories.store');
    Route::get('/subcategories/edit/{id}', [SubCategoryController::class, 'edit'])->name('subcategories.edit');
    Route::PATCH('/subcategories/update/{id}', [SubCategoryController::class, 'update'])->name('subcategories.update');
    Route::get('/subcategories/delete/{id}', [SubCategoryController::class, 'destroy'])->name('subcategories.destroy');
    Route::post('/subcategories/featured', [SubCategoryController::class,'update_featured'])->name('subcategories.featured');

    
    //Payment Methods Configuration
    Route::get('/payment_methods', [PaymentMethodController::class,'index'])->name('payment_methods.index');
    Route::get('/payment_methods/create', [PaymentMethodController::class,'create'])->name('payment_methods.create');
    Route::post('/payment_methods/store', [PaymentMethodController::class,'store'])->name('payment_methods.store');
    Route::get('/payment_methods/edit/{id}', [PaymentMethodController::class,'edit'])->name('payment_methods.edit');
    Route::PATCH('/payment_methods/update/{id}', [PaymentMethodController::class,'update'])->name('payment_methods.update');
    Route::get('/payment_methods/destroy/{id}', [PaymentMethodController::class,'destroy'])->name('payment_methods.destroy');
    Route::post('/payment_methods/status', [PaymentMethodController::class,'update_status'])->name('payment_methods.status');
    
    //social media
    Route::get('/social_media', [SocialMediaController::class,'index'])->name('social_media.index');
    Route::get('/social_media/create', [SocialMediaController::class,'create'])->name('social_media.create');
    Route::post('/social_media/store', [SocialMediaController::class,'store'])->name('social_media.store');
    Route::get('/social_media/edit/{id}', [SocialMediaController::class,'edit'])->name('social_media.edit');
    Route::PATCH('/social_media/update/{id}', [SocialMediaController::class,'update'])->name('social_media.update');
    Route::get('/social_media/destroy/{id}', [SocialMediaController::class,'destroy'])->name('social_media.destroy');
    Route::post('/social_media/status', [SocialMediaController::class,'socialMediaStatusUpdate'])->name('social_media.status');


    //Shipping Companies
    Route::get('/shipping_companies', [ShippingCompanyController::class,'index'])->name('shipping_companies.index');
    // Route::get('/shipping_companies/create', [ShippingCompanyController::class,'create'])->name('shipping_companies.create');
    // Route::post('/shipping_companies/store', [ShippingCompanyController::class,'store'])->name('shipping_companies.store');
    Route::get('/shipping_companies/edit/{id}', [ShippingCompanyController::class, 'edit'])->name('shipping_companies.edit');
    Route::PATCH('/shipping_companies/update/{id}', [ShippingCompanyController::class,'update'])->name('shipping_companies.update');
    Route::get('/shipping_companies/delete/{id}', [ShippingCompanyController::class, 'destroy'])->name('shipping_companies.destroy');
    Route::post('/shipping_companies/status', [ShippingCompanyController::class,'update_status'])->name('shipping_companies.status');


    //Ads 
    // Route::resource('ads', AdsController::class);
    Route::get('/ads', [AdsController::class,'index'])->name('ads.index');
    Route::get('/ads/create', [AdsController::class,'create'])->name('ads.create');
    Route::post('/ads/store', [AdsController::class,'store'])->name('ads.store');
    Route::get('/ads/edit/{id}', [AdsController::class, 'edit'])->name('ads.edit');
    Route::PATCH('/ads/update/{id}', [AdsController::class,'update'])->name('ads.update');
    Route::get('/ads/delete/{id}', [AdsController::class, 'destroy'])->name('ads.destroy');
    Route::post('/ads/status', [AdsController::class,'update_status'])->name('ads.status');
    Route::post('/ads/featured', [AdsController::class,'update_featured'])->name('ads.featured');

    //Sliders
    // Route::resource('sliders', SliderController::class);
    Route::get('/sliders', [SliderController::class,'index'])->name('sliders.index');
    Route::get('/sliders/create', [SliderController::class,'create'])->name('sliders.create');
    Route::post('/sliders/store', [SliderController::class, 'store'])->name('sliders.store');
    Route::get('/sliders/edit/{id}', [SliderController::class,'edit'])->name('sliders.edit');
    Route::PATCH('/sliders/update/{id}', [SliderController::class,'update'])->name('sliders.update');
    Route::get('/sliders/delete/{id}', [SliderController::class,'destroy'])->name('sliders.destroy');
    Route::post('/sliders/published', [SliderController::class,'update_published'])->name('sliders.published');
    

    // Route::resource('pages', 'PageController');
    // Route::get('/pages/destroy/{id}', 'PageController@destroy')->name('pages.destroy');

    Route::resource('countries', '\App\Http\Controllers\Admin\CountryController');
    Route::post('/countries/status', [CountryController::class,'updateStatus'])->name('countries.status');

    Route::resource('states','\App\Http\Controllers\Admin\StateController');
	Route::post('/states/status', [StateController::class,'updateStatus'])->name('states.status');

    Route::resource('cities', '\App\Http\Controllers\Admin\CityController');
    Route::get('/cities/edit/{id}', [CityController::class,'edit'])->name('cities.edit');
    Route::get('/cities/destroy/{id}', [CityController::class,'destroy'])->name('cities.destroy');
    Route::post('/cities/status', [CityController::class,'updateStatus'])->name('cities.status');

    Route::view('/system/update', 'backend.system.update')->name('system_update');
    Route::view('/system/server-status', 'backend.system.server_status')->name('system_server');

    // uploaded files
    Route::any('/uploaded-files/file-info', [AizUploadController::class,'file_info'])->name('uploaded-files.info');
    Route::resource('/uploaded-files', '\App\Http\Controllers\Admin\AizUploadController');
    Route::get('/uploaded-files/destroy/{id}', [AizUploadController::class,'destroy'])->name('uploaded-files.destroy');

    Route::get('/all-notification', [NotificationController::class,'index'])->name('admin.all-notification');

    Route::get('/cache-cache', [AdminController::class,'clearCache'])->name('cache.clear');
});
