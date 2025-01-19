@extends('frontend.layout')

@section('content')
    <div class="cat-landing">
        <p>تسوق</p>
    </div>
    @php
    $min = 0 ;$max = 0;
       if(!(\App\Models\Product::count() < 1))
           $min = \App\Models\Product::min('unit_price');
       $max = \App\Models\Product::max('unit_price');

@endphp
    <div class="cat-content">
        <div id="layer-filter-product" class="layer"></div>
        <div class="right" id="filter-menu">
            <form action="{{url('shop')}}" method="GET">
            <div class="price-slider">
                <h5>
                    <span id="close-btn-filter"><i class="fa-solid fa-xmark"></i>اغلق</span>
                </h5>
                <h4>تصفية حسب السعر</h4>
                <div class="price-content">    
                    <label for="">السعر</label>
                    
                    <p id="minamount"></p>
                    -
                    <p id="maxamount"></p>
                </div>           
                <div class="range-slider" dir="ltr">
                    <div class="range-fill" id="range-slider-id"></div>
                
                    <input type="range" class="min-price" name="min_price" value="10"
                        id="input-minamount" min="10" max="500" step="10" />
                
                    <input type="range" class="max-price" name="max_price" value="500"
                        id="input-maxamount" min="10" max="500" step="10" />
                </div>
            </div>

            <div class="brand-filter">
                <p>تصفية حسب الماركة</p>
                {{-- <div class="search">
                    <input type="text" name="brand" placeholder="ابحث عن الماركه" />
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div> --}}
                <div class="brands">
                    @foreach ($brands as $brand)
                        <div class="brand">
                            <label for="brand-{{ $brand->id }}">
                                <input type="checkbox" name="brand_id" value="{{ $brand->id }}" id="brand-{{ $brand->id }}" />
                                {{ $brand->name }}
                            </label>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="btn">
                <button type="submit">تصفية</button>
            </div>
        </form>
        </div>
        <div class="left">
            <div class="head">
                <div class="route">
                    <div class="main-route"><a href="{{url('/')}}">الرئيسيه</a></div>
                    /
                    <div class="category">قائمة المنتجات</div>
                </div>

                <div class="sub-filter">

                    {{-- <form id="form2" method="get" action="{{url('shop')}}">
                        
                    </form>  --}}

                    <form id="form1" method="get" class="flex" action="{{url('shop')}}">
                        <div class=" flex mx-3">

                            <div class="grid-item mx-1">
                                <label title="عرض 9 منتج">
                                    <input type="radio" name="pagination" value="9" 
                                    onchange="this.form.submit()" {{($pagination == 9)?'selected':''}} />
                                    <div class="grid-3" id="btn-grid-3">
                                        <span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>
                                    </div>
                                </label>
                            </div>

                            <div class="grid-item mx-1">
                                <label title="عرض 12 منتج">
                                    <input type="radio" name="pagination" value="12" 
                                    onchange="this.form.submit()" {{($pagination == 12)?'selected':''}} />
                                    <div class="grid-3" id="btn-grid-3">
                                        <span></span><span></span><span></span>
                                        <span></span><span></span><span></span>
                                        <span></span><span></span><span></span>
                                        <span></span><span></span><span></span>
                                    </div>
                                </label>
                            </div>

                            <div class="grid-item mx-1">
                                <label title="عرض 15 منتج">
                                    <input type="radio" name="pagination" value="15" 
                                    onchange="this.form.submit()" {{($pagination == 15)?'selected':''}} />
                                    <div class="grid-3" id="btn-grid-3">
                                        <span></span><span></span><span></span>
                                        <span></span><span></span><span></span>
                                        <span></span><span></span><span></span>
                                        <span></span><span></span><span></span>
                                        <span></span><span></span><span></span>
                                        {{-- <span></span><span></span><span></span>
                                        <span></span><span></span> --}}
                                    </div>  
                                </label>
                            </div>
                            </div>
                    <select name="sort_by" onchange="this.form.submit()">
                        <option value="best-seller" {{($sort_by == 'best-seller')?'selected':''}}>
                            ترتيب بالاكثر مبيعا
                        </option>
                        <option value="best-review" {{($sort_by == 'best-review')?'selected':''}}>
                            ترتيب بتقيم العملاء
                        </option>
                        <option value="newest" {{($sort_by == 'newest')?'selected':''}}>
                            ترتيب حسب الاحدث
                        </option>
                        <option value="oldest" {{($sort_by == 'oldest')?'selected':''}}>
                            ترتيب حسب الاقدم
                        </option>
                        <option value="price-asc" {{($sort_by == 'price-asc')?'selected':''}}>
                            ترتيب حسب السعر الأقل
                        </option>
                        <option value="price-desc" {{($sort_by == 'price-desc')?'selected':''}}>
                            ترتيب حسب السعر الأعلى
                        </option>
                    </select>
                </form>
                </div>
            </div>
            <div class="filter-btn-small-screen">
                <button id="btn-toggle-filter" data-expanded="false">
                    <p>التصفيات</p>
                    <span class="nav-toggler-icon"> </span>
                </button>
            </div>
            @if ($products->count() > 0)
            <div class="products" id="product-cat">

                @foreach ($products as $product)
                    @include('frontend.product.product', ['product' => $product])
                @endforeach
            </div>
                @else
                <div class="col-12 product">
                    <div class="card">
                        <div class="card-img-top">

                                <img class="image-cover"  src="{{ static_asset('assets/img/nothing.svg') }}" alt="product">

                        </div>
                        <div class="card-body">

                            <p class="woocommerce-loop-product__title">{{__('front.No Product Found')}}</p>

                        </div>
                    </div>

                </div>
            @endif
        <div class="loading-more">

            <ul class="pagination justify-content-center">
                <li class="page-item">{{$products->links()}}</li>

            </ul>

        </div>
        </div>
    </div>
@endsection



<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Get elements
        const minPriceInput = document.getElementById("input-minamount");
        const maxPriceInput = document.getElementById("input-maxamount");
        const minAmountDisplay = document.getElementById("minamount");
        const maxAmountDisplay = document.getElementById("maxamount");
        const filterButton = document.getElementById("filter-btn");

        // Update displayed price values
        const updatePriceDisplay = () => {
            minAmountDisplay.textContent = `$${minPriceInput.value}`;
            maxAmountDisplay.textContent = `$${maxPriceInput.value}`;
        };

        // Event listeners for range inputs
        minPriceInput.addEventListener("input", updatePriceDisplay);
        maxPriceInput.addEventListener("input", updatePriceDisplay);

        // Initialize display
        updatePriceDisplay();

        // AJAX request on filter button click
        filterButton.addEventListener("click", function () {
            const minPrice = minPriceInput.value;
            const maxPrice = maxPriceInput.value;

            fetch('/filter-products', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    min_price: minPrice,
                    max_price: maxPrice,
                }),
            })
            .then(response => response.json())
            .then(data => {
                // Update products display
                const productsContainer = document.getElementById("products-container");
                productsContainer.innerHTML = '';

                if (data.products.length > 0) {
                    data.products.forEach(product => {
                        productsContainer.innerHTML += `
                            <div class="product">
                                <h5>${product.name}</h5>
                                <p>Price: $${product.price}</p>
                            </div>
                        `;
                    });
                } else {
                    productsContainer.innerHTML = '<p>No products found for the selected range.</p>';
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
</script>





<script type="text/javascript">
    function filter() {

        $('input[name=min_price]').val(querystring("min_price"));
        $('input[name=max_price]').val(querystring("max_price"));
        $('#search-form').submit();
    }

    function rangefilter(arg) {
        $('input[name=min_price]').val(arg[0]);
        $('input[name=max_price]').val(arg[1]);
        $('#search-form').submit();
    }

    function querystring(key) {
        var re = new RegExp('(?:\\?|&)' + key + '=(.*?)(?=&|$)', 'gi');
        var r = [],
            m;
        while ((m = re.exec(document.location.search)) != null) r.push(m[1]);
        return r;
    }
</script>
<script>
    function updateQueryString() {
        var form1Data = $('#form1').serialize();
        // console.log(form1Data);
        var form2Data = $('#form2').serialize();

        var combinedData = form1Data + '&' + form2Data;

        var url = "{{url('search')}}?" + combinedData;

        window.location.href = url;
    }

    function showAddToCartModal(id){
        if(!$('#modal-size').hasClass('modal-lg')){
            $('#modal-size').addClass('modal-lg');
        }
        $('#addToCart-modal-body').html(null);
        $('#addToCart').modal();
        $('.c-preloader').show();
        $.post('<?php echo e(route('cart.showCartModal')); ?>', {_token: AIZ.data.csrf, id:id}, function(data){
            $('.c-preloader').hide();
            $('#addToCart-modal-body').html(data);
            AIZ.plugins.slickCarousel();
            AIZ.plugins.zoom();
            AIZ.extra.plusMinus();
            getVariantPrice();
        });
    }


    function getVariantPrice(){
        if($('#option-choice-form input[name=quantity]').val() > 0 && checkAddToCartValidity()){
            $.ajax({
                type:"POST",
                url: '<?php echo e(route('products.variant_price')); ?>',
                data: $('#option-choice-form').serializeArray(),
                success: function(data){

                    $('.product-gallery-thumb .carousel-box').each(function (i) {
                        if($(this).data('variation') && data.variation == $(this).data('variation')){
                            $('.product-gallery-thumb').slick('slickGoTo', i);
                        }
                    })

                    $('#option-choice-form #chosen_price_div').removeClass('d-none');
                    $('#option-choice-form #chosen_price_div #chosen_price').html(data.price);
                    $('#available-quantity').html(data.quantity);
                    $('.input-number').prop('max', data.max_limit);
                    if(parseInt(data.in_stock) == 0 && data.digital  == 0){
                        $('.buy-now').addClass('d-none');
                        $('.add-to-cart').addClass('d-none');
                        $('.out-of-stock').removeClass('d-none');
                    }
                    else{
                        $('.buy-now').removeClass('d-none');
                        $('.add-to-cart').removeClass('d-none');
                        $('.out-of-stock').addClass('d-none');
                    }
                }
            });
        }
    }

    function addToCart(){

        if(checkAddToCartValidity()) {
            $('#addToCart').modal();
            $('.c-preloader').show();
            $.ajax({
                type:"POST",
                url: '<?php echo e(route('cart.addToCart')); ?>',
                data: $('#option-choice-form').serializeArray(),
                success: function(data){

                    $('#addToCart-modal-body').html(null);
                    $('.c-preloader').hide();
                    $('#modal-size').removeClass('modal-lg');
                    $('#addToCart-modal-body').html(data.modal_view);
                    AIZ.extra.plusMinus();
                    updateNavCart(data.nav_cart_view,data.cart_count);
                }
            });
        }
        else{
            AIZ.plugins.notify('warning', "<?php echo e(__('front.please choose all the options')); ?>");
        }
    }

    function checkAddToCartValidity(){
        var names = {};
        $('#option-choice-form input:radio').each(function() { // find unique names
            names[$(this).attr('name')] = true;
        });
        var count = 0;
        $.each(names, function() { // then count them
            count++;
        });

        if($('#option-choice-form input:radio:checked').length == count){
            return true;
        }

        return false;
    }

    function updateNavCart(view,count){
        $('.cart-count').html(count);
        $('#cart_items').html(view);
    }


    function buyNow(){
        if(checkAddToCartValidity()) {
            $('#addToCart-modal-body').html(null);
            $('#addToCart').modal();
            $('.c-preloader').show();
            $.ajax({
                type:"POST",
                url: '{{ route('cart.addToCart') }}',
                data: $('#option-choice-form').serializeArray(),
                success: function(data){
                    if(data.status == 1){

                        $('#addToCart-modal-body').html(data.modal_view);
                        updateNavCart(data.nav_cart_view,data.cart_count);

                        window.location.replace("{{ route('cart') }}");
                    }
                    else{
                        $('#addToCart-modal-body').html(null);
                        $('.c-preloader').hide();
                        $('#modal-size').removeClass('modal-lg');
                        $('#addToCart-modal-body').html(data.modal_view);
                    }
                }
            });
        }
        else{
            AIZ.plugins.notify('warning', "{{ __('front.please choose all the options') }}");
        }
    }

    function addToWishList(id){
        @if (Auth::check() && (Auth::user()->user_type == 'customer' || Auth::user()->user_type == 'seller'))
        $.post('{{ route('wishlists.store') }}', {_token: AIZ.data.csrf, id:id}, function(data){
            if(data != 0){
                $('#wishlist').html(data);
                AIZ.plugins.notify('success', "{{ translate('Item has been added to wishlist') }}");
            }
            else{
                AIZ.plugins.notify('warning', "{{ translate('Please login first') }}");
            }
        });
        @else
        AIZ.plugins.notify('warning', "{{ translate('Please login first') }}");
        @endif
    }
</script>




