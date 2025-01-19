@extends('frontend.layout')
@php
    $countOfAds = count($ads);
@endphp
@section('content')
    <!-- start banner section -->
    <section class="banner">
        <div class="container">
            <div class="banner-cont">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach ($sliders as $slider)
                            <div class="swiper-slide">
                                <a href="#">
                                    {{-- <img src="{{ asset('images/banner1.jpg') }}" alt="Image 1" /> --}}
                                    <img src="{{ uploaded_asset($slider->getTranslation('photo')) }}" alt=" slider image "
                                        onerror="this.onerror=null;this.src='{{ asset('images/banar5.jpg') }}'">
                                </a>
                            </div>
                        @endforeach

                    </div>
                    <div class="swiper-pagination"></div>
                    <!-- Pagination -->
                </div>

                <div class="left-image">
                    @foreach ($ads as $key => $ad)
                        @if ($key == $countOfAds - 1)
                            <a href="#">
                                <img src="{{ uploaded_asset($ad->getTranslation('banner')) }}"
                                    alt=" ad image {{ $ad->getTranslation('name') }}"
                                    onerror="this.onerror=null;this.src='{{ asset('images/banar3.jpg') }}'"
                                    class=" w-250px image-fit">
                            </a>
                        @elseif($key == $countOfAds - 2)
                            <a href="#">
                                <img src="{{ uploaded_asset($ad->getTranslation('banner')) }}"
                                    alt=" ad image {{ $ad->getTranslation('name') }}"
                                    onerror="this.onerror=null;this.src='{{ asset('images/banar2.jpg') }}'"
                                    class=" w-250px image-fit">
                            </a>
                        @endif
                    @endforeach

                    {{-- <a href="#"><img src="{{ asset('images/banar-6.jpg') }}" alt="" /></a> --}}
                </div>
            </div>
        </div>
    </section>

    <!-- End banner section -->

    <!-- Start categories -->

    <div class="categories">
        <div class="container">
            <h2>تسوق الاقسام</h2>
            <div class="all">
                @foreach ($cats as $cat)
                    <div class="box">
                        <a href="{{ route('products.category', $cat->slug) }}">
                            <img src="{{ uploaded_asset($cat->icon) }}" alt="{{ $cat->name }}"
                                onerror="this.onerror=null;this.src='{{ asset('images/fe-3.jpg') }}'"
                                class=" size-200px image-fit" />
                            <h3>{{ __($cat->name) }}</h3>
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

    <!-- End categories -->

    <!-- Start about us -->
    <div class="about">
        <div class="container">
            <h3>من نحن !</h3>
            <div class="content">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/zFSNh7S9U9Q"
                    title="Hamid El Shari #60 SE6 | حوارات مع عباس - حميد الشاعري" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe>
            </div>
        </div>
    </div>
    <!-- End about us -->

    <!-- Start ads -->
    <div class="ads">
        <div class="container">
            <div class="right">
                @foreach ($ads as $key => $ad)
                    @if ($key == $countOfAds - 3)
                        <img src="{{ asset('images/banar3.jpg') }}"
                            data-src="{{ uploaded_asset($ad->getTranslation('banner')) }}"
                            alt=" ad image {{ $ad->getTranslation('name') }}" class="  h-full image-fit"
                            onerror="this.onerror=null;this.src='{{ asset('images/banar3.jpg') }}">
                    @endif
                    @if ($key == $countOfAds - 4)
                        <img src="{{ asset('images/banar5.jpg') }}"
                            data-src="{{ uploaded_asset($ad->getTranslation('banner')) }}"
                            alt=" ad image {{ $ad->getTranslation('name') }}" class="  h-full image-fit"
                            onerror="this.onerror=null;this.src='{{ asset('images/baner5.jpg') }}">
                    @endif
                @endforeach
                {{-- <img src="{{ asset('images/banar3.jpg') }}" alt="" />
                <img src="{{ asset('images/banar5.jpg') }}" alt="" /> --}}
            </div>

            <div class="left">
                @foreach ($ads as $key => $ad)
                    @if ($key == $countOfAds - 5)
                        <img src="{{ asset('images/baner3.jpg') }}"
                            data-src="{{ uploaded_asset($ad->getTranslation('banner')) }}"
                            alt=" ad image {{ $ad->getTranslation('name') }}" class=" image-fit"
                            onerror="this.onerror=null;this.src='{{ asset('images/banar3.jpg') }}">
                    @endif
                    @if ($key == $countOfAds - 6)
                        <img src="{{ asset('images/baner5.jpg') }}"
                            data-src="{{ uploaded_asset($ad->getTranslation('banner')) }}"
                            alt=" ad image {{ $ad->getTranslation('name') }}" class=" image-fit"
                            onerror="this.onerror=null;this.src='{{ asset('images/baner5.jpg') }}">
                    @endif
                @endforeach
                <img src="{{ asset('images/banar2.jpg') }}" alt="" class=" image-fit" />
                <img src="{{ asset('images/banner1.jpg') }}" alt="" class=" image-fit" />
            </div>
        </div>
    </div>
    <!-- End ads -->

    <!-- Start features -->
    <div class="features">
        <div class="container">
            <h3>منتجات مميزه</h3>

            {{-- <ul class="nav nav-tabs justify-content-center buttons border-0 " id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link  rounded-0 bg-white border-0" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                        type="button" role="tab" aria-controls="home-tab-pane" aria-selected="false">
                        <h4>أحدث المنتجات</h4>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-0 bg-white border-0" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                        type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="true">
                        <h4>الأكثر مبيعاً</h4>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-0 bg-white border-0" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane"
                        type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">
                        <h4>تخفيضات</h4>
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade " id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                    tabindex="0">
                    <div class="products">
                        @foreach ($news as $newProduct)
                            @include('frontend.product.product', ['product' => $newProduct])
                        @endforeach
        
                    </div>
                </div>
                <div class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel"
                    aria-labelledby="profile-tab" tabindex="0">
                    <div class="products">
                        @foreach ($bests as $bestProduct)
                            @include('frontend.product.product', ['product' => $bestProduct])
                        @endforeach
        
                    </div>
                </div>
                <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab"
                    tabindex="0">
                    <div class="products">
                        @foreach ($hots as $hotProduct)
                            @include('frontend.product.product', ['product' => $hotProduct])
                        @endforeach
        
                    </div>
                </div>
            </div> --}}
            {{-- <div class="buttons">
                <h4>أحدث المنتجات</h4>
                <h4>الأكثر مبيعاً</h4>
                <h4>تخفيضات</h4>
            </div> --}}
            <div class="products">
                @foreach ($bests as $bestProduct)
                    @include('frontend.product.product', ['product' => $bestProduct])
                @endforeach

            </div>
        </div>
    </div>
    <!-- End features -->

    <!-- Start New Arrival -->
    <div class="arrival">
        <div class="container">
            <h2>أحدث المنتجات</h2>
            <div class="content">
                <div class="swiper-new-arrival">
                    <div class="swiper-wrapper">
                        @foreach ($news as $newProduct)
                            <div class="swiper-slide">

                                @include('frontend.product.slider_product', ['product' => $newProduct])
                            </div>
                        @endforeach
                    </div>

                    <!-- Navigation buttons -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>

                <div class="banner-new">
                    @foreach ($ads as $key => $ad)
                        @if ($key == $countOfAds - 7)
                            <img src="{{ asset('assets') }}/img/placeholder.jpg"
                                data-src="{{ uploaded_asset($ad->getTranslation('banner')) }}"
                                alt=" ad image {{ $ad->getTranslation('name') }}"
                                onerror="this.onerror=null;this.src='{{ asset('images/banar3.jpg') }}">
                        @endif
                    @endforeach
                    <img src="{{ asset('images/left-ads.png') }}" alt="" />
                </div>
            </div>
        </div>
    </div>
    <!-- End New Arrival -->

    <!-- Start best seller -->
    <div class="seller">
        <div class="container">
            <h2>الاكتر مبيعا</h2>
            <div class="content">
                <div class="banner-new">
                    @foreach ($ads as $key => $ad)
                        @if ($key == $countOfAds - 8)
                            <img src="{{ asset('assets') }}/img/placeholder.jpg"
                                data-src="{{ uploaded_asset($ad->getTranslation('banner')) }}"
                                alt=" ad image {{ $ad->getTranslation('name') }}"
                                onerror="this.onerror=null;this.src='{{ asset('images/banar3.jpg') }}">
                        @endif
                    @endforeach
                    <img src="{{ asset('images/left-ads.png') }}" alt="" />
                </div>

                <div class="swiper-new-arrival">
                    <div class="swiper-wrapper">
                        @foreach ($productLevel as $levelProd)
                            <div class="swiper-slide">
                                @include('frontend.product.slider_product', ['product' => $levelProd])
                            </div>
                        @endforeach

                    </div>

                    <!-- Navigation buttons -->
                    <div class="swiper-button-next left-next"></div>
                    <div class="swiper-button-prev left-prev"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- End New Arrival -->

    <!-- Start articles -->
    <div class="articles">
        <div class="container">
            <h3>المقالات</h3>

            <div class="content">
                <div class="swiper-articles">
                    <div class="swiper-wrapper">
                        @foreach ($blogs as $blog)
                            <div class="swiper-slide">
                                <div class="box h-20px">
                                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                        data-src="{{ uploaded_asset($blog->banner) }}" alt="{{ $blog->title }}"
                                        onerror="this.onerror=null;this.src='{{ asset('images/banner1.jpg') }}'">
                                    <h4> <a href="{{ url('blog') . '/' . $blog->slug }}">{{ $blog->title }}</a></h4>
                                    <p>{{ $blog->short_description }} </p>

                                    <a class="mt-2" href="{{ url('blog') . '/' . $blog->slug }}">اكمل القراءه</a>
                                </div>
                            </div>
                        @endforeach
                        <div class="swiper-slide">
                            <div class="box">
                                <img src="{{ asset('images/banar2.jpg') }}" alt="Image 2" />
                                <h4>
                                    <a href="">
                                        الاضاءه المناسبه للمذكره
                                    </a>
                                </h4>
                                <p>
                                    للإضاءة تأثير كبير على الدراسة والتحصيل، حيث أنها عامل مهم
                                    للتركيز والفهم. ليس هذا فقط،
                                </p>
                                <p>اكمل القراءه</p>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="box">
                                <img src="{{ asset('images/banar2.jpg') }}" alt="Image 2" />
                                <h4>الاضاءه المناسبه للمذكره</h4>
                                <p>
                                    للإضاءة تأثير كبير على الدراسة والتحصيل، حيث أنها عامل مهم
                                    للتركيز والفهم. ليس هذا فقط،
                                </p>
                                <p>اكمل القراءه</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="box">
                                <img src="{{ asset('images/banar-8.jpg') }}" alt="Image 3" />
                                <h4>الاضاءه المناسبه للمذكره</h4>
                                <p>
                                    للإضاءة تأثير كبير على الدراسة والتحصيل، حيث أنها عامل مهم
                                    للتركيز والفهم. ليس هذا فقط،
                                </p>
                                <p>اكمل القراءه</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="box">
                                <img src="{{ asset('images/banner1.jpg') }}" alt="" />
                                <h4>الاضاءه المناسبه للمذكره</h4>
                                <p>
                                    للإضاءة تأثير كبير على الدراسة والتحصيل، حيث أنها عامل مهم
                                    للتركيز والفهم. ليس هذا فقط،
                                </p>
                                <p>اكمل القراءه</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="box">
                                <img src="{{ asset('images/banar5.jpg') }}" alt="Image 5" />
                                <h4>الاضاءه المناسبه للمذكره</h4>
                                <p>
                                    للإضاءة تأثير كبير على الدراسة والتحصيل، حيث أنها عامل مهم
                                    للتركيز والفهم. ليس هذا فقط،
                                </p>
                                <p>اكمل القراءه</p>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation buttons -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- End articles -->

    <!-- Start services -->
    <div class="services">
        <div class="box">
            <img id="lll" src="{{ asset('images/استبدال.png') }}" alt="" />
            <h4>الإستبدال و الإسترجاع</h4>
        </div>
        <div class="box">
            <img src="{{ asset('images/خدمه.png') }}" alt="" />
            <h4>خدمة العملاء</h4>
        </div>
        <div class="box">
            <img src="{{ asset('images/دفع.png') }}" alt="" />
            <h4>دفع أون لاين</h4>
        </div>
        <div class="box">
            <img src="{{ asset('images/شحن.png') }}" alt="" />
            <h4>شحن مجاني</h4>
        </div>
    </div>

    <!-- End services -->
@endsection
