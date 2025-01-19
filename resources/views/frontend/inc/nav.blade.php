<header class="sticky">
    <div class="discount">
        <div class="right">
            <a href="#"> <img src="{{ asset('images/en.png') }}" alt="" />ENGLISH</a>
            <p>خصم إضافي 10% على طلبك! كود خصم: BF10</p>
        </div>
        <div class="left">
            @auth
                @if (isAdmin())
                    <a href="{{ route('admin.dashboard') }}"><i class="fa fa-user"></i>{{ __('لوحة التحكم') }}</a>
                @else
                    <div>
                        <a href="{{ route('user') }}"><i class="fa fa-user"></i>{{ __('لوحة التحكم') }}</a>
                    </div>
                @endif
                <div>
                    <a href="{{ route('logout') }}"><i class="fa fa-user"></i>{{ __('تسجيل الخروج') }}</a>
                </div>
            @else
                <span class="user" href="" id="user-open">حسابى</span>
            @endauth
            <div class="icons-m">
                <a href=""><i class="fa-brands fa-facebook-f"></i></a>
                <a href=""><i class="fa-brands fa-instagram"></i></a>
                <a href=""><i class="fa-brands fa-tiktok"></i></a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="header-top">
            @include('frontend.partials.cart_wishlist')

            <div class="flex-grow-1 front-header-search d-flex align-items-center bg-white">

                <div class="position-relative flex-grow-1">
                    <form method="get" action="{{ url('search') }}" class="stop-propagation">

                        <div class="d-flex position-relative align-items-center">
                            <div class="d-lg-none" data-toggle="class-toggle" data-target=".front-header-search">
                                <button class="btn px-2" type="button"><i
                                        class="la la-2x la-long-arrow-left"></i></button>
                            </div>
                            <div class="input-group">
                                <input type="text" class="border-0 border-lg form-control" id="search"
                                    name="search"
                                    @isset($query)
                                value="{{ $query }}"
                                       @endisset
                                    placeholder="{{ __('front.i am shopping for...') }}" autocomplete="off">
                                <div class="input-group-append d-none_important d-lg-block">
                                    <button class="btn btn-primary search" type="submit">
                                        <i class="la la-search la-flip-horizontal fs-18" style="color: white;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="typed-search-box  stop-propagation document-click-d-none d-none  bg-white rounded shadow-lg position-absolute left-0 top-100 w-100"
                        style="min-height: 200px;z-index: 300;">
                        <div class="search-preloader absolute-top-center">
                            <div class="dot-loader">
                                <div>

                                </div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                        <div class="search-nothing d-none p-3 text-center fs-16">

                        </div>
                        <div id="search-content" class="text-left">

                        </div>
                    </div>

                </div>
            </div>


            <div class="language">

                <a class="holder" id="lang-active">
                    <img src="{{ asset('images/Flag_of_Saudi_Arabia.svg-150x150.png') }}" alt="" />
                    <p>السعودية</p>
                    <i class="fa-solid fa-chevron-down"></i>
                </a>


                <div class="box">
                    {{-- {{ route('language.change', 'en') }} --}}
                    <a href="#" class="lang" value="en" id="lang-en">
                        <img src="{{ asset('images/en.png') }}" alt="" />
                        <p>ENGLISH</p>
                    </a>
                    {{-- {{ route('language.change', 'ar') }} --}}
                    <a href="#" class="lang" value="ar" id="lang-ar">
                        <img src="{{ asset('images/Flag_of_Saudi_Arabia.svg-150x150.png') }}" alt="" />
                        <p>السعودية</p>
                    </a>
                </div>
            </div>



            <div class="log">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/logo-removebg-preview.png') }}" alt="logo photo" />
                </a>
            </div>
            <button id="btn-toggle" data-expanded="false">
                <p>القائمة</p>
                <span class="nav-toggler-icon"> </span>
            </button>
        </div>
        @php
            $cats = \App\Models\Category::with('subCategories')->get(); // edit by mohamed
        @endphp
        <div class="header-bottom">
            <ul>
                @foreach ($cats as $cat)
                    <li>
                        <a href="">{{ $cat->name }}<i class="fa-solid fa-chevron-down"></i></a>
                        <ul class="list-n">
                            @foreach ($cat->subCategories as $subCategory)
                                <li>
                                    <a href="">
                                        <img src="{{ uploaded_asset($subCategory->icon) }}" alt="photo"
                                            style="width: 100px; padding: 10px;" />
                                        {{ $subCategory->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
            <div class="search">
                <form method="get" action="{{ url('search') }}" class="stop-propagation">
                    <input type="text" class="border-0 border-lg form-control" id="search" name="search"
                        @isset($query)
                            value="{{ $query }}"
                        @endisset
                        placeholder="{{ __('front.i am shopping for...') }}" autocomplete="off">
                </form>
            </div>
        </div>
    </div>
    <!-- Start main menu -->
    <div class="main-menu">
        <div class="search">
            <form method="get" action="{{ url('search') }}">
                <input type="text" class="border-0 border-lg form-control" id="search" name="search"
                    @isset($query)
                value="{{ $query }}"
                @endisset
                    placeholder="{{ __('front.i am shopping for...') }}" autocomplete="off">
                <i class="fa-solid fa-magnifying-glass"></i>
            </form>
        </div>

        <ul>
            <li><a href="{{ url('/') }}">الرئيسية</a></li>
            <li><a href="">احدث المنتجات</a></li>
            <li><a href="{{ url('shop') }}">المنتجات</a></li>
            <li><a href="{{ url('blog') }}">المدونه</a></li>
            <li><a href="">عروض</a></li>
            <li><a href="">احدث المنتجات</a></li>
            <li class="country">
                <span>تغير الدولة<i class="fa-solid fa-chevron-down"></i> </span>
                <ul id="country-menu">
                    <li>
                        <a class="lang">
                            <img src="{{ asset('images/en.png') }}" alt="" />
                            <p>ENGLISH</p>
                        </a>
                    </li>
                    <li>
                        <a class="lang">
                            <img src="{{ asset('images/Flag_of_Saudi_Arabia.svg-150x150.png') }}" alt="" />
                            <p>السعودية</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li><a href="{{ url('contact') }}">اتصل بينا</a></li>
            <li>
                <a href=""><i class="fa-solid fa-heart heart"></i>التفضيلات </a>
            </li>
            <li>
                @auth
                    <span>
                        <a href="{{ route('logout') }}"><i class="fa fa-user"></i>{{ __('تسجيل الخروج') }}</a>
                    </span>
                @else
                    <span id="user-open">
                        <a href="{{ url('login') }}">
                            <i class="fa-regular fa-user"></i>حسابى
                        </a>
                    </span>
                    {{-- <span class="user" href="" id="user-open">حسابى</span> --}}
                @endauth
            </li>
        </ul>
    </div>
    <!-- Start main menu -->
    {{-- @php
   dd(Auth::id());
@endphp --}}
    <!-- Start User menu -->
    <div class="user-account" id="user-account">

        <h4>
            تسجيل الدخول<span id="close-btn"><i class="fa-solid fa-xmark"></i>اغلق</span>
        </h4>

        <form role="form" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="name">
                <label for="user">إسم المستخدم او البريد الإليكتروني </label>
                <input type="text" name="email" id="username"
                    class="{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}"
                    autocomplete="off" placeholder="{{ translate('Email') }}" />
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="pass">
                <label for="password">كلمة السر </label>
                <input type="password" class="{{ $errors->has('password') ? ' is-invalid' : '' }}"
                    placeholder="Password" name="password" id="pass">
            </div>
            <button>تسجيل الدخول</button>
            <div class="end">
                <label for="remember">
                    <input type="checkbox" id="save-pass" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    تذكرني
                </label>
                <a href="{{ url('password/reset') }}">نسيت كلمه السر؟</a>
            </div>
            <div class="new-user">
                <i class="fa-regular fa-user"></i>
                <span>ليس لديك حساب؟</span>
                <a href="{{ route('register') }}">سجل حساب جديد</a>
            </div>
        </form>
    </div>
    <!-- End User menu -->

    <!-- Start cart menu -->
    {{-- <div class="dropdown-menu dropdown-menu-lg p-0 stop-propagation dropdown-menu-custom"> --}}
    <div class="user-cart" id="cart_items">
        <h4>
            سلة المشتريات<span id="close-btn-cart"><i class="fa-solid fa-xmark"></i>اغلق</span>
        </h4>
        @include('frontend.partials.cart')
    </div>
    {{-- </div> --}}

    <div class="user-cart" id="cart_items">

        @if (isset($cart) && count($cart) > 0)

            <ul class="h-250px overflow-auto c-scrollbar-light list-group list-group-flush">
                @foreach ($cart as $key => $cartItem)
                    @php
                        $product_image = null;
                        $product = \App\Models\Product::find($cartItem['product_id']);
                        $total = $total + $cartItem['price'] * $cartItem['quantity'];
                        $product_stock = $product->stocks->where('variant', $cartItem['variation'])->first();
                        if ($cartItem['variation'] != null) {
                            $product_image = $product_stock->image;
                        }
                    @endphp
                    @if ($product != null)
                        <li class="list-group-item">
                            <img src="{{ asset('assets') }}/img/placeholder.jpg"
                                data-src="{{ uploaded_asset($product_image != null ? $product_image : $product->thumbnail_img) }}"
                                class="img-fit lazyload size-60px rounded"
                                alt="{{ $product->getTranslation('name') }}">
                            <span class="" style="color:#000; font-size: 0.5em;">
                                {{ trimString($product->getTranslation('name'), 30) }}
                            </span>
                            <br>
                            <span>
                                <span class="">{{ $cartItem['quantity'] }}x</span>
                                <span class="">{{ single_price($cartItem['price']) }}</span>

                            </span>

                            <span>
                                <button onclick="removeFromCart({{ $cartItem['id'] }})"
                                    class="btn btn-sm btn-icon stop-propagation">
                                    <i class="la la-trash la-bold"
                                        style="color: red; font-weight: bold; font-size: larger"></i>
                                </button>
                            </span>

                        </li>
                    @endif
                @endforeach
            </ul>
            <div class="px-3 py-2 fs-15 border-top d-flex justify-content-between">
                <span class="opacity-60">{{ __('front.subtotal') }}</span>
                <span class="fw-600">{{ single_price($total) }}</span>
            </div>
            <div class="px-3 py-2 text-center border-top">
                <p>Tax & customs fees included</p>
            </div>
            <div class="px-3 py-2 text-center border-top">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <a href="{{ route('cart') }}" class="btn btn-soft-primary btn-sm" style="color: white">
                            {{ __('front.view cart') }}
                        </a>
                    </li>
                    @if (Auth::check())
                        <li class="list-inline-item">
                            <a href="{{ route('checkout.shipping_info') }}" class="btn btn-primary btn-sm"
                                style="color: white">
                                {{ __('front.checkout') }}
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        @else
            <div class="content">
                <p>لا يوجد منتجات فى سله المشتريات</p>
                <button id="btn-cart-back">العوده للتسوق</button>
            </div>
        @endif
    </div>

    <!-- End cart menu -->




    <!-- layer to hidden content behind the meun -->
    <div id="layer" class="layer"></div>
</header>
