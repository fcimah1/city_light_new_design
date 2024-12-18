<div class="aiz-sidebar-wrap">
    <div class="aiz-sidebar left c-scrollbar">
        <div class="aiz-side-nav-logo-wrap">
            <a href="{{ route('admin.dashboard') }}" class="d-block text-left">
                @if (get_setting('system_logo_white') != null)
                    <img class="mw-100" src="{{asset('imager')}}/home/logo-dark.png"
                        class="brand-icon" alt="{{ get_setting('site_name') }}">
                @else
                    <img class="mw-100" src="{{ static_asset('assets/img/logo-dark.png') }}" class="brand-icon"
                        alt="{{ get_setting('site_name') }}">
                @endif
            </a>
        </div>
        <div class="aiz-side-nav-wrap">
            <div class="px-20px mb-3">
                <input class="form-control bg-soft-secondary border-0 form-control-sm text-white" type="text" name=""
                    placeholder="{{ translate('Search in menu') }}" id="menu-search" onkeyup="menuSearch()">
            </div>
            <ul class="aiz-side-nav-list" id="search-menu">
            </ul>
            <ul class="aiz-side-nav-list" id="main-menu" data-toggle="aiz-side-menu">
                <li class="aiz-side-nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Dashboard') }}</span>
                    </a>
                </li>




                <!-- Product -->
                @if (Auth::user()->user_type == 'admin' || in_array('2', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-shopping-cart aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Products') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <!--Submenu-->
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a class="aiz-side-nav-link" href="{{ route('products.create') }}">
                                    <span class="aiz-side-nav-text">{{ translate('Add New product') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('products.all') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('All Products') }}</span>
                                </a>
                            </li>

                            @php
                                $conversation = \App\Models\Conversation::where('receiver_id', Auth::user()->id)->where('receiver_viewed', '1')->get();
                            @endphp
                            @if(Auth::user()->user_type == 'admin' || in_array('12', json_decode(Auth::user()->staff->role->permissions)))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('conversations.admin_index') }}" class="aiz-side-nav-link {{ areActiveRoutes(['conversations.admin_index', 'conversations.admin_show'])}}">
                                        <span class="aiz-side-nav-text">{{translate('Product Queries')}}</span>
                                        @if (count($conversation) > 0)
                                            <span class="badge badge-info">{{ count($conversation) }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif


{{--                            <li class="aiz-side-nav-item">--}}
{{--                                <a href="{{route('attributes.index')}}" class="aiz-side-nav-link {{ areActiveRoutes(['attributes.index','attributes.create','attributes.edit'])}}">--}}
{{--                                    <span class="aiz-side-nav-text">{{translate('Attribute')}}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="aiz-side-nav-item">--}}
{{--                                <a href="{{route('colors')}}" class="aiz-side-nav-link {{ areActiveRoutes(['attributes.index','attributes.create','attributes.edit'])}}">--}}
{{--                                    <span class="aiz-side-nav-text">{{translate('Colors')}}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}

{{--                            <li class="aiz-side-nav-item">--}}
{{--                                <a href="{{ route('products.admin') }}"--}}
{{--                                    class="aiz-side-nav-link {{ areActiveRoutes(['products.admin', 'products.create', 'products.admin.edit']) }}">--}}
{{--                                    <span class="aiz-side-nav-text">{{ translate('In House Products') }}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}



                            <li class="aiz-side-nav-item">
                                <a href="{{ route('categories.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['categories.index', 'categories.create', 'categories.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Category') }}</span>
                                </a>
                            </li>

                            <li class="aiz-side-nav-item">
                                <a href="{{ route('subcategories.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['subcategories.index', 'subcategories.create', 'subcategories.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('SubCategory') }}</span>
                                </a>
                            </li>

                            <li class="aiz-side-nav-item">
                                <a href="{{ route('brands.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['brands.index', 'brands.create', 'brands.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Brand') }}</span>
                                </a>
                            </li>


                        </ul>
                    </li>
                @endif



                <!-- Sale -->
                <li class="aiz-side-nav-item">
                    <a href="#" class="aiz-side-nav-link">
                        <i class="las la-money-bill aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Sales') }}</span>
                        <span class="aiz-side-nav-arrow"></span>
                    </a>
                    <!--Submenu-->
                    <ul class="aiz-side-nav-list level-2">
                        @if (Auth::user()->user_type == 'admin' || in_array('3', json_decode(Auth::user()->staff->role->permissions)))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('all_orders.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['all_orders.index', 'all_orders.show']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('All Orders') }}</span>
                                </a>
                            </li>
                        @endif

{{--                        @if (Auth::user()->user_type == 'admin' || in_array('4', json_decode(Auth::user()->staff->role->permissions)))--}}
{{--                            <li class="aiz-side-nav-item">--}}
{{--                                <a href="{{ route('inhouse_orders.index') }}"--}}
{{--                                    class="aiz-side-nav-link {{ areActiveRoutes(['inhouse_orders.index', 'inhouse_orders.show']) }}">--}}
{{--                                    <span class="aiz-side-nav-text">{{ translate('Inhouse orders') }}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endif--}}

                        @if (Auth::user()->user_type == 'admin' || in_array('6', json_decode(Auth::user()->staff->role->permissions)))
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('pick_up_point.order_index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['pick_up_point.order_index', 'pick_up_point.order_show']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Pick-up Point Order') }}</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>



                <!-- Customers -->
                @if (Auth::user()->user_type == 'admin' || in_array('8', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user-friends aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Customers') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('customers.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Customer list') }}</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif


                @if (Auth::user()->user_type == 'admin' || in_array('22', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('uploaded-files.index') }}"
                            class="aiz-side-nav-link {{ areActiveRoutes(['uploaded-files.create']) }}">
                            <i class="las la-folder-open aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Uploaded Files') }}</span>
                        </a>
                    </li>
                @endif
                <!-- Reports -->
                @if (Auth::user()->user_type == 'admin' || in_array('10', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-file-alt aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Reports') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('in_house_sale_report.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['in_house_sale_report.index']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('In House Product Sale') }}</span>
                                </a>
                            </li>
{{--                            <li class="aiz-side-nav-item">--}}
{{--                                <a href="{{ route('seller_sale_report.index') }}"--}}
{{--                                    class="aiz-side-nav-link {{ areActiveRoutes(['seller_sale_report.index']) }}">--}}
{{--                                    <span class="aiz-side-nav-text">{{ translate('Seller Products Sale') }}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('stock_report.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['stock_report.index']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Products Stock') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('wish_report.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['wish_report.index']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Products wishlist') }}</span>
                                </a>
                            </li>
{{--                            <li class="aiz-side-nav-item">--}}
{{--                                <a href="{{ route('user_search_report.index') }}"--}}
{{--                                    class="aiz-side-nav-link {{ areActiveRoutes(['user_search_report.index']) }}">--}}
{{--                                    <span class="aiz-side-nav-text">{{ translate('User Searches') }}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="aiz-side-nav-item">--}}
{{--                                <a href="{{ route('commission-log.index') }}" class="aiz-side-nav-link">--}}
{{--                                    <span class="aiz-side-nav-text">{{ translate('Commission History') }}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="aiz-side-nav-item">--}}
{{--                                <a href="{{ route('wallet-history.index') }}" class="aiz-side-nav-link">--}}
{{--                                    <span--}}
{{--                                        class="aiz-side-nav-text">{{ translate('Wallet Recharge History') }}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
                        </ul>
                    </li>
                @endif

                @if (Auth::user()->user_type == 'admin' || in_array('23', json_decode(Auth::user()->staff->role->permissions)))
                    <!--Blog System-->
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-bullhorn aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Blog System') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('blog.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['blog.create', 'blog.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('All Posts') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('blog-category.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['blog-category.create', 'blog-category.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Categories') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- marketing -->
                @if (Auth::user()->user_type == 'admin' || in_array('11', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-bullhorn aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Marketing') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            @if (Auth::user()->user_type == 'admin' || in_array('2', json_decode(Auth::user()->staff->role->permissions)))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('flash_deals.index') }}"
                                        class="aiz-side-nav-link {{ areActiveRoutes(['flash_deals.index', 'flash_deals.create', 'flash_deals.edit']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Flash deals') }}</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->user_type == 'admin' || in_array('7', json_decode(Auth::user()->staff->role->permissions)))
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('newsletters.index') }}" class="aiz-side-nav-link">
                                        <span class="aiz-side-nav-text">{{ translate('Newsletters') }}</span>
                                    </a>
                                </li>

                            @endif
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('subscribers.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Subscribers') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('coupon.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['coupon.index', 'coupon.create', 'coupon.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Coupon') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif


{{--                <!-- Offline Payment Addon-->--}}
{{--                @if (addon_is_activated('offline_payment'))--}}
{{--                    @if (Auth::user()->user_type == 'admin' || in_array('16', json_decode(Auth::user()->staff->role->permissions)))--}}
{{--                        <li class="aiz-side-nav-item">--}}
{{--                            <a href="#" class="aiz-side-nav-link">--}}
{{--                                <i class="las la-money-check-alt aiz-side-nav-icon"></i>--}}
{{--                                <span class="aiz-side-nav-text">{{ translate('Offline Payment System') }}</span>--}}
{{--                                @if (env('DEMO_MODE') == 'On')--}}
{{--                                    <span class="badge badge-inline badge-danger">Addon</span>--}}
{{--                                @endif--}}
{{--                                <span class="aiz-side-nav-arrow"></span>--}}
{{--                            </a>--}}
{{--                            <ul class="aiz-side-nav-list level-2">--}}
{{--                                <li class="aiz-side-nav-item">--}}
{{--                                    <a href="{{ route('manual_payment_methods.index') }}"--}}
{{--                                        class="aiz-side-nav-link {{ areActiveRoutes(['manual_payment_methods.index','manual_payment_methods.create','manual_payment_methods.edit']) }}">--}}
{{--                                        <span--}}
{{--                                            class="aiz-side-nav-text">{{ translate('Manual Payment Methods') }}</span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li class="aiz-side-nav-item">--}}
{{--                                    <a href="{{ route('offline_wallet_recharge_request.index') }}"--}}
{{--                                        class="aiz-side-nav-link">--}}
{{--                                        <span--}}
{{--                                            class="aiz-side-nav-text">{{ translate('Offline Wallet Recharge') }}</span>--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                @if (get_setting('classified_product') == 1)--}}
{{--                                    <li class="aiz-side-nav-item">--}}
{{--                                        <a href="{{ route('offline_customer_package_payment_request.index') }}"--}}
{{--                                            class="aiz-side-nav-link">--}}
{{--                                            <span--}}
{{--                                                class="aiz-side-nav-text">{{ translate('Offline Customer Package--}}
{{--                                                                                    Payments') }}</span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                @endif--}}
{{--                                @if (addon_is_activated('seller_subscription'))--}}
{{--                                    <li class="aiz-side-nav-item">--}}
{{--                                        <a href="{{ route('offline_seller_package_payment_request.index') }}"--}}
{{--                                            class="aiz-side-nav-link">--}}
{{--                                            <span--}}
{{--                                                class="aiz-side-nav-text">{{ translate('Offline Seller Package Payments') }}</span>--}}
{{--                                            @if (env('DEMO_MODE') == 'On')--}}
{{--                                                <span class="badge badge-inline badge-danger">Addon</span>--}}
{{--                                            @endif--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                @endif--}}
{{--                            </ul>--}}
{{--                        </li>--}}
{{--                    @endif--}}
{{--                @endif--}}

                <!-- Club Point Addon-->
                @if (addon_is_activated('club_point'))
                    @if (Auth::user()->user_type == 'admin' || in_array('18', json_decode(Auth::user()->staff->role->permissions)))
                        <li class="aiz-side-nav-item">
                            <a href="#" class="aiz-side-nav-link">
                                <i class="lab la-btc aiz-side-nav-icon"></i>
                                <span class="aiz-side-nav-text">{{ translate('Club Point System') }}</span>
                                @if (env('DEMO_MODE') == 'On')
                                    <span class="badge badge-inline badge-danger">Addon</span>
                                @endif
                                <span class="aiz-side-nav-arrow"></span>
                            </a>
                            <ul class="aiz-side-nav-list level-2">
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('club_points.configs') }}" class="aiz-side-nav-link">
                                        <span
                                            class="aiz-side-nav-text">{{ translate('Club Point Configurations') }}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('set_product_points') }}"
                                        class="aiz-side-nav-link {{ areActiveRoutes(['set_product_points', 'product_club_point.edit']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('Set Product Point') }}</span>
                                    </a>
                                </li>
                                <li class="aiz-side-nav-item">
                                    <a href="{{ route('club_points.index') }}"
                                        class="aiz-side-nav-link {{ areActiveRoutes(['club_points.index', 'club_point.details']) }}">
                                        <span class="aiz-side-nav-text">{{ translate('User Points') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif


{{--                <!-- Website Setup -->--}}
{{--                @if (Auth::user()->user_type == 'admin' || in_array('13', json_decode(Auth::user()->staff->role->permissions)))--}}
{{--                    <li class="aiz-side-nav-item">--}}
{{--                        <a href="#"--}}
{{--                            class="aiz-side-nav-link {{ areActiveRoutes(['website.footer', 'website.header']) }}">--}}
{{--                            <i class="las la-desktop aiz-side-nav-icon"></i>--}}
{{--                            <span class="aiz-side-nav-text">{{ translate('Website Setup') }}</span>--}}
{{--                            <span class="aiz-side-nav-arrow"></span>--}}
{{--                        </a>--}}
{{--                        <ul class="aiz-side-nav-list level-2">--}}
{{--                            <li class="aiz-side-nav-item">--}}
{{--                                <a href="{{ route('website.header') }}" class="aiz-side-nav-link">--}}
{{--                                    <span class="aiz-side-nav-text">{{ translate('Header') }}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="aiz-side-nav-item">--}}
{{--                                <a href="{{ route('website.footer', ['lang' => App::getLocale()]) }}"--}}
{{--                                    class="aiz-side-nav-link {{ areActiveRoutes(['website.footer']) }}">--}}
{{--                                    <span class="aiz-side-nav-text">{{ translate('Footer') }}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="aiz-side-nav-item">--}}
{{--                                <a href="{{ route('website.pages') }}"--}}
{{--                                    class="aiz-side-nav-link {{ areActiveRoutes(['website.pages', 'custom-pages.create', 'custom-pages.edit']) }}">--}}
{{--                                    <span class="aiz-side-nav-text">{{ translate('Pages') }}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="aiz-side-nav-item">--}}
{{--                                <a href="{{ route('website.appearance') }}" class="aiz-side-nav-link">--}}
{{--                                    <span class="aiz-side-nav-text">{{ translate('Appearance') }}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                @endif--}}

                <!-- Setup & Configurations -->
                @if (Auth::user()->user_type == 'admin' || in_array('14', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-dharmachakra aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Setup & Configurations') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
{{--                            <li class="aiz-side-nav-item">--}}
{{--                                <a href="{{ route('general_setting.index') }}" class="aiz-side-nav-link">--}}
{{--                                    <span class="aiz-side-nav-text">{{ translate('General Settings') }}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}

{{--                            <li class="aiz-side-nav-item">--}}
{{--                                <a href="{{ route('activation.index') }}" class="aiz-side-nav-link">--}}
{{--                                    <span class="aiz-side-nav-text">{{ translate('Features activation') }}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="aiz-side-nav-item">--}}
{{--                                <a href="{{ route('languages.index') }}"--}}
{{--                                    class="aiz-side-nav-link {{ areActiveRoutes(['languages.index','languages.create','languages.store','languages.show','languages.edit']) }}">--}}
{{--                                    <span class="aiz-side-nav-text">{{ translate('Languages') }}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}

{{--                            <li class="aiz-side-nav-item">--}}
{{--                                <a href="{{ route('currency.index') }}" class="aiz-side-nav-link">--}}
{{--                                    <span class="aiz-side-nav-text">{{ translate('Currency') }}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}


                            <li class="aiz-side-nav-item">
                                <a href="{{ route('tax.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['tax.index', 'tax.create', 'tax.store', 'tax.show', 'tax.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('Vat & TAX') }}</span>
                                </a>
                            </li>
{{--                            <li class="aiz-side-nav-item">--}}
{{--                                <a href="{{ route('pick_up_points.index') }}"--}}
{{--                                    class="aiz-side-nav-link {{ areActiveRoutes(['pick_up_points.index', 'pick_up_points.create', 'pick_up_points.edit']) }}">--}}
{{--                                    <span class="aiz-side-nav-text">{{ translate('Pickup point') }}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="aiz-side-nav-item">--}}
{{--                                <a href="{{ route('smtp_settings.index') }}" class="aiz-side-nav-link">--}}
{{--                                    <span class="aiz-side-nav-text">{{ translate('SMTP Settings') }}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('payment_methods.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Payment Methods') }}</span>
                                </a>
                            </li>
                            
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('social_media.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Social Media') }}</span>
                                </a>
                            </li>
                            
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('shipping_companies.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Shipping Companies') }}</span>
                                </a>
                            </li>
{{--                            <li class="aiz-side-nav-item">--}}
{{--                                <a href="{{ route('file_system.index') }}" class="aiz-side-nav-link">--}}
{{--                                    <span--}}
{{--                                        class="aiz-side-nav-text">{{ translate('File System & Cache--}}
{{--                                                                            Configuration') }}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="aiz-side-nav-item">--}}
{{--                                <a href="{{ route('social_login.index') }}" class="aiz-side-nav-link">--}}
{{--                                    <span class="aiz-side-nav-text">{{ translate('Social media Logins') }}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}

{{--                            <li class="aiz-side-nav-item">--}}
{{--                                <a href="javascript:void(0);" class="aiz-side-nav-link">--}}
{{--                                    <span class="aiz-side-nav-text">{{ translate('Facebook') }}</span>--}}
{{--                                    <span class="aiz-side-nav-arrow"></span>--}}
{{--                                </a>--}}
{{--                                <ul class="aiz-side-nav-list level-3">--}}
{{--                                    <li class="aiz-side-nav-item">--}}
{{--                                        <a href="{{ route('facebook_chat.index') }}" class="aiz-side-nav-link">--}}
{{--                                            <span class="aiz-side-nav-text">{{ translate('Facebook Chat') }}</span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li class="aiz-side-nav-item">--}}
{{--                                        <a href="{{ route('facebook-comment') }}" class="aiz-side-nav-link">--}}
{{--                                            <span--}}
{{--                                                class="aiz-side-nav-text">{{ translate('Facebook Comment') }}</span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </li>--}}

{{--                            <li class="aiz-side-nav-item">--}}
{{--                                <a href="javascript:void(0);" class="aiz-side-nav-link">--}}
{{--                                    <span class="aiz-side-nav-text">{{ translate('Google') }}</span>--}}
{{--                                    <span class="aiz-side-nav-arrow"></span>--}}
{{--                                </a>--}}
{{--                                <ul class="aiz-side-nav-list level-3">--}}
{{--                                    <li class="aiz-side-nav-item">--}}
{{--                                        <a href="{{ route('google_analytics.index') }}" class="aiz-side-nav-link">--}}
{{--                                            <span class="aiz-side-nav-text">{{ translate('Analytics Tools') }}</span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li class="aiz-side-nav-item">--}}
{{--                                        <a href="{{ route('google_recaptcha.index') }}" class="aiz-side-nav-link">--}}
{{--                                            <span--}}
{{--                                                class="aiz-side-nav-text">{{ translate('Google reCAPTCHA') }}</span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li class="aiz-side-nav-item">--}}
{{--                                        <a href="{{ route('google-map.index') }}" class="aiz-side-nav-link">--}}
{{--                                            <span class="aiz-side-nav-text">{{ translate('Google Map') }}</span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li class="aiz-side-nav-item">--}}
{{--                                        <a href="{{ route('google-firebase.index') }}" class="aiz-side-nav-link">--}}
{{--                                            <span class="aiz-side-nav-text">{{ translate('Google Firebase') }}</span>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </li>--}}




                            <li class="aiz-side-nav-item">
                                <a href="javascript:void(0);" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Shipping') }}</span>
                                    <span class="aiz-side-nav-arrow"></span>
                                </a>
                                <ul class="aiz-side-nav-list level-3">
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('shipping_configuration.index') }}"
                                            class="aiz-side-nav-link {{ areActiveRoutes(['shipping_configuration.index','shipping_configuration.edit','shipping_configuration.update']) }}">
                                            <span
                                                class="aiz-side-nav-text">{{ translate('Shipping Configuration') }}</span>
                                        </a>
                                    </li>
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('countries.index') }}"
                                            class="aiz-side-nav-link {{ areActiveRoutes(['countries.index', 'countries.edit', 'countries.update']) }}">
                                            <span
                                                class="aiz-side-nav-text">{{ translate('Shipping Countries') }}</span>
                                        </a>
                                    </li>
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('states.index') }}"
                                            class="aiz-side-nav-link {{ areActiveRoutes(['states.index', 'states.edit', 'states.update']) }}">
                                            <span class="aiz-side-nav-text">{{ translate('Shipping States') }}</span>
                                        </a>
                                    </li>
                                    <li class="aiz-side-nav-item">
                                        <a href="{{ route('cities.index') }}"
                                            class="aiz-side-nav-link {{ areActiveRoutes(['cities.index', 'cities.edit', 'cities.update']) }}">
                                            <span class="aiz-side-nav-text">{{ translate('Shipping Cities') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </li>
                @endif


                <!-- Staffs -->
                @if (Auth::user()->user_type == 'admin' || in_array('20', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-user-tie aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Staffs') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('staffs.index') }}"
                                    class="aiz-side-nav-link {{ areActiveRoutes(['staffs.index', 'staffs.create', 'staffs.edit']) }}">
                                    <span class="aiz-side-nav-text">{{ translate('All staffs') }}</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif
                
                <!--Ads-->
                @if (Auth::user()->user_type == 'admin' || in_array('9', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-ad aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Ads') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('ads.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Ads list') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('ads.create') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Add new Ads') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                
                <!--Slider-->
                @if (Auth::user()->user_type == 'admin' || in_array('9', json_decode(Auth::user()->staff->role->permissions)))
                    <li class="aiz-side-nav-item">
                        <a href="#" class="aiz-side-nav-link">
                            <i class="las la-ad aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Slider') }}</span>
                            <span class="aiz-side-nav-arrow"></span>
                        </a>
                        <ul class="aiz-side-nav-list level-2">
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('sliders.index') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Slider list') }}</span>
                                </a>
                            </li>
                            <li class="aiz-side-nav-item">
                                <a href="{{ route('sliders.create') }}" class="aiz-side-nav-link">
                                    <span class="aiz-side-nav-text">{{ translate('Add new Slider') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif



            </ul><!-- .aiz-side-nav -->
        </div><!-- .aiz-side-nav-wrap -->
    </div><!-- .aiz-sidebar -->
    <div class="aiz-sidebar-overlay"></div>
</div><!-- .aiz-sidebar -->
