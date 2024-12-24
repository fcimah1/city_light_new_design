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
                                    <img src="{{ asset('images/banner1.jpg') }}" alt="Image 1" />
                                    <img
                                        src="{{asset('assets')}}/img/placeholder.jpg"
                                        data-src="{{ uploaded_asset($slider->getTranslation('photo')) }}"
                                        alt=" slider image "
                                        onerror="this.onerror=null;this.src='{{asset('images/banner1.jpg')}}">
                                </a>
                            </div>
                        @endforeach
                       
                    </div>
                    <div class="swiper-pagination"></div>
                    <!-- Pagination -->
                </div>

                <div class="left-image">
                    @foreach ($ads as $key => $ad )
                    @if ($key == ($countOfAds-1))
                        <a href="#">
                            <img 
                                src="{{asset('assets')}}/img/placeholder.jpg"
                                data-src="{{ uploaded_asset($ad->getTranslation('banner')) }}"
                                alt=" ad image {{$ad->getTranslation('name')}}"
                                onerror="this.onerror=null;this.src='{{asset('images/banner1.jpg')}}">
                        </a>
                    @elseif($key == ($countOfAds-2))
                        <a href="#">
                            <img 
                                src="{{asset('assets')}}/img/placeholder.jpg"
                                data-src="{{ uploaded_asset($ad->getTranslation('banner')) }}"
                                alt=" ad image {{$ad->getTranslation('name')}}"
                                onerror="this.onerror=null;this.src='{{asset('images/banner1.jpg')}}">
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
                        <a href="#"><img src="{{ uploaded_asset($cat->icon) }}" alt="{{ $cat->name }}" />
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
                @foreach ($ads as $key => $ad )
                    @if ($key == ($countOfAds-3))
                            <img 
                            src="{{asset('assets')}}/img/placeholder.jpg"
                            data-src="{{ uploaded_asset($ad->getTranslation('banner')) }}"
                            alt=" ad image {{$ad->getTranslation('name')}}"
                            onerror="this.onerror=null;this.src='{{asset('images/banar3.jpg')}}">
                    @endif
                    @if ($key == ($countOfAds-4))
                            <img 
                            src="{{asset('assets')}}/img/placeholder.jpg"
                            data-src="{{ uploaded_asset($ad->getTranslation('banner')) }}"
                            alt=" ad image {{$ad->getTranslation('name')}}"
                            onerror="this.onerror=null;this.src='{{asset('images/baner5.jpg')}}">
                    @endif
                @endforeach
                {{-- <img src="{{ asset('images/banar3.jpg') }}" alt="" />
                <img src="{{ asset('images/banar5.jpg') }}" alt="" /> --}}
            </div>

            <div class="left">
                @foreach ($ads as $key => $ad )
                    @if ($key == ($countOfAds - 5))
                            <img 
                            src="{{asset('assets')}}/img/placeholder.jpg"
                            data-src="{{ uploaded_asset($ad->getTranslation('banner')) }}"
                            alt=" ad image {{$ad->getTranslation('name')}}"
                            onerror="this.onerror=null;this.src='{{asset('images/banar3.jpg')}}">
                    @endif
                    @if ($key == ($countOfAds - 6))
                            <img 
                            src="{{asset('assets')}}/img/placeholder.jpg"
                            data-src="{{ uploaded_asset($ad->getTranslation('banner')) }}"
                            alt=" ad image {{$ad->getTranslation('name')}}"
                            onerror="this.onerror=null;this.src='{{asset('images/baner5.jpg')}}">
                    @endif
                @endforeach 
                <img src="{{ asset('images/banar2.jpg') }}" alt="" />
                <img src="{{ asset('images/banner1.jpg') }}" alt="" />
            </div>
        </div>
    </div>
    <!-- End ads -->

    <!-- Start features -->
    <div class="features">
        <div class="container">
            <h3>منتجات مميزه</h3>
            <div class="buttons">
                <h4>أحدث المنتجات</h4>
                <h4>الأكثر مبيعاً</h4>
                <h4>تخفيضات</h4>
            </div>
            <div class="products">
                @foreach ($bests as $bestProduct)
                <div class="box">
                    <div class="image">
                        <img
                            class="img-fit lazyload mx-auto h-310px h-md-310px"
                            src="{{asset('assets')}}/img/placeholder.jpg"
                            data-src="{{ uploaded_asset($bestProduct->thumbnail_img) }}"
                            alt=" product image {{ $bestProduct->getTranslation('name') }}"
                            onerror="this.onerror=null;this.src='{{asset('images/fe-1.jpg')}}">

                        @if (discount_in_percentage($bestProduct) > 0)
                            <span class="discount"> {{discount_in_percentage($bestProduct)}}%</span>
                            <i class="fa-solid fa-heart heart"></i>
                        @endif
                    </div>
                    <p>{{ $bestProduct->getTranslation('name') }}</p>
                    <p>
                        <span class="total">
                            <bdo dir="ltr">
                                @if (home_base_price($bestProduct) != home_discounted_base_price($bestProduct))
                                    <span class="price"> {{ home_discounted_base_price($bestProduct) }} </span> 
                                    <del>{{ home_base_price($bestProduct) }} </del>
                                @else
                                    <span class="price"> {{ home_base_price($bestProduct) }} </span> 
                                @endif
                                
                            </bdo></span>
                    </p>
                    <button>اضف الى السله</button>
                </div>
                @endforeach
                <div class="box">
                    <div class="image">
                        <img src="{{ asset('images/fe-1.jpg') }}" alt="" />
                        <span class="discount"> -34%</span>
                        <i class="fa-solid fa-heart heart"></i>
                    </div>
                    <p>أباجورة تيمورا 1 لمبة أسود</p>
                    <p>
                        <span class="total"><bdo dir="ltr"><span class="price"> 747 EGP</span> <del>1,099
                                    EGP</del></bdo></span>
                    </p>
                    <button>اضف الى السله</button>
                </div>
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
                                <div class="box">
                                    <img
                                        src="{{asset('assets')}}/img/placeholder.jpg"
                                        data-src="{{ uploaded_asset($newProduct->thumbnail_img) }}"
                                        alt=" product image {{ $newProduct->getTranslation('name') }}"
                                        onerror="this.onerror=null;this.src='{{asset('images/new-3.jpg')}}">
                                    <h4 dir="ltr">{{ $newProduct->getTranslation('name')}}</h4>
                                    <button>اضف الى السله</button>
                                </div>
                            </div>
                            @endforeach
        
                        <div class="swiper-slide">
                            <div class="box">
                                <img src="{{ asset('images/new-5.png') }}" alt="Image 5" />
                                <h4><bdo dir="ltr">spot light</bdo></h4>
                                <button>اضف الى السله</button>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation buttons -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>

                <div class="banner-new">
                    @foreach ($ads as $key => $ad )
                        @if ($key == ($countOfAds - 7))
                                <img 
                                src="{{asset('assets')}}/img/placeholder.jpg"
                                data-src="{{ uploaded_asset($ad->getTranslation('banner')) }}"
                                alt=" ad image {{$ad->getTranslation('name')}}"
                                onerror="this.onerror=null;this.src='{{asset('images/banar3.jpg')}}">
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
                    @foreach ($ads as $key => $ad )
                        @if ($key == ($countOfAds - 8))
                                <img 
                                src="{{asset('assets')}}/img/placeholder.jpg"
                                data-src="{{ uploaded_asset($ad->getTranslation('banner')) }}"
                                alt=" ad image {{$ad->getTranslation('name')}}"
                                onerror="this.onerror=null;this.src='{{asset('images/banar3.jpg')}}">
                        @endif
                    @endforeach
                    <img src="{{ asset('images/left-ads.png') }}" alt="" />
                </div>

                <div class="swiper-new-arrival">
                    <div class="swiper-wrapper">
                        @foreach ($productLevel as $levelProd)
                            <div class="swiper-slide">
                                <div class="box">
                                    <img
                                        src="{{asset('assets')}}/img/placeholder.jpg"
                                        data-src="{{ uploaded_asset($levelProd->thumbnail_img) }}"
                                        alt=" product image {{ $levelProd->getTranslation('name') }}"
                                        onerror="this.onerror=null;this.src='{{asset('images/new-3.jpg')}}">
                                    <h4 dir="ltr">{{ $levelProd->getTranslation('name')}}</h4>
                                    {{-- <a href="{{ route('product', $levelProd->slug) }}">اضف الى السله</a> --}}
                                    <button type="button" onclick="{{ route('product', $levelProd->slug) }}">اضف الى السله</button>
                                </div>
                            </div>
                        @endforeach
                        <div class="swiper-slide">
                            <div class="box">
                                <img src="{{ asset('images/new-1.png') }}" alt="Image 2" />
                                <h4><bdo dir="ltr">spot light</bdo></h4>
                                <button type="button" onclick="addToCart()">اضف الى السله</button>
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
                            <div class="box">
                                <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                    data-src="{{ uploaded_asset($blog->banner) }}" alt="{{ $blog->title }}">

                                <h4> <a href="{{ url('blog') . '/' . $blog->slug }}">{{ $blog->title }}</a></h4>
                                <p>{{ $blog->short_description }} </p>

                                <a href="{{ url('blog') . '/' . $blog->slug }}">اكمل القراءه</a>
                            </div>
                        </div>
                        @endforeach
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
            <img src="{{ asset('images/استبدال.png') }}" alt="" />
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

@section('script')

<script src="{{ asset('new') }}/js/jquery-3.3.1.min.js"></script>
<script src="{{ asset('new') }}/js/bootstrap.min.js"></script>
<script src="{{ asset('new') }}/js/jquery-ui.min.js"></script>
<script src="{{ asset('new') }}/js/jquery.countdown.min.js"></script>
<script src="{{ asset('new') }}/js/jquery.nice-select.min.js"></script>
<script src="{{ asset('new') }}/js/jquery.zoom.min.js"></script>
<script src="{{ asset('new') }}/js/jquery.dd.min.js"></script>
<script src="{{ asset('new') }}/js/jquery.slicknav.js"></script>
<script src="{{ asset('new') }}/js/owl.carousel.min.js"></script>
<script src="{{ asset('new') }}/js/main.js"></script>
<script src="{{ static_asset('assets/js/vendors.js') }}"></script>

<script>
    function showAddToCartModal(id) {
        if (!$('#modal-size').hasClass('modal-lg')) {
            $('#modal-size').addClass('modal-lg');
        }
        $('#addToCart-modal-body').html(null);
        $('#addToCart').modal();
        $('.c-preloader').show();
        $.post('<?php echo e(route('cart.showCartModal')); ?>', {
            _token: AIZ.data.csrf,
            id: id
        }, function(data) {
            $('.c-preloader').hide();
            $('#addToCart-modal-body').html(data);
            AIZ.plugins.slickCarousel();
            AIZ.plugins.zoom();
            AIZ.extra.plusMinus();
            getVariantPrice();
        });
    }

    function getVariantPrice() {
        if ($('#option-choice-form input[name=quantity]').val() > 0 && checkAddToCartValidity()) {
            $.ajax({
                type: "POST",
                url: '<?php echo e(route('products.variant_price')); ?>',
                data: $('#option-choice-form').serializeArray(),
                success: function(data) {

                    $('.product-gallery-thumb .carousel-box').each(function(i) {
                        if ($(this).data('variation') && data.variation == $(this).data(
                            'variation')) {
                            $('.product-gallery-thumb').slick('slickGoTo', i);
                        }
                    })

                    $('#option-choice-form #chosen_price_div').removeClass('d-none');
                    $('#option-choice-form #chosen_price_div #chosen_price').html(data.price);
                    $('#available-quantity').html(data.quantity);
                    $('.input-number').prop('max', data.max_limit);
                    if (parseInt(data.in_stock) == 0 && data.digital == 0) {
                        $('.buy-now').addClass('d-none');
                        $('.add-to-cart').addClass('d-none');
                        $('.out-of-stock').removeClass('d-none');
                    } else {
                        $('.buy-now').removeClass('d-none');
                        $('.add-to-cart').removeClass('d-none');
                        $('.out-of-stock').addClass('d-none');
                    }
                }
            });
        }
    }


    
    function addToCart() {
        if (checkAddToCartValidity()) {
            $('#addToCart').modal();
            $('.c-preloader').show();
            $.ajax({
                type: "POST",
                url: '<?php echo e(route('cart.addToCart')); ?>',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    $('#option-choice-form').serializeArray(),
                    id: id
                }
                success: function(data) {

                    $('#addToCart-modal-body').html(null);
                    $('.c-preloader').hide();
                    $('#modal-size').removeClass('modal-lg');
                    $('#addToCart-modal-body').html(data.modal_view);
                    AIZ.extra.plusMinus();
                    updateNavCart(data.nav_cart_view, data.cart_count);
                }
            });
        } else {
            AIZ.plugins.notify('warning', "<?php echo e(__('front.please choose all the options')); ?>");
        }
    }

    function checkAddToCartValidity() {
        var names = {};
        $('#option-choice-form input:radio').each(function() { // find unique names
            names[$(this).attr('name')] = true;
        });
        var count = 0;
        $.each(names, function() { // then count them
            count++;
        });

        if ($('#option-choice-form input:radio:checked').length == count) {
            return true;
        }

        return false;
    }

    function addToWishList(id) {
        @if (Auth::check() && (Auth::user()->user_type == 'customer' || Auth::user()->user_type == 'seller'))
            $.post('{{ route('wishlists.store') }}', {
                _token: AIZ.data.csrf,
                id: id
            }, function(data) {
                if (data != 0) {
                    $('#wishlist').html(data);
                    AIZ.plugins.notify('success', "{{ translate('Item has been added to wishlist') }}");
                } else {
                    AIZ.plugins.notify('warning', "{{ translate('Please login first') }}");
                }
            });
        @else
            AIZ.plugins.notify('warning', "{{ translate('Please login first') }}");
        @endif
    }
</script>


<script>
    function updateBackgrounds() {
        var screenWidth = window.innerWidth;

        $('.set-bg').each(function() {
            var defaultBg = $(this).data('setbg');
            var mobileBg = $(this).data('setbg-mobile');

            if (screenWidth <= 768 && mobileBg) {
                $(this).css('background-image', 'url(' + mobileBg + ')');
            } else {
                $(this).css('background-image', 'url(' + defaultBg + ')');
            }
        });
    }

    // Initial call to set backgrounds based on screen size
    updateBackgrounds();

    // Update backgrounds on window resize
    window.addEventListener('resize', updateBackgrounds);
</script>
@endsection
