 <div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
    @if (discount_in_percentage($product) > 0)
        <span class="badge-custom">{{ __('front.OFF') }}<span
                class="box ml-1 mr-0">&nbsp;{{ discount_in_percentage($product) }}%</span></span>
        <p class="onsale-product"> -{{ discount_in_percentage($product) }}%</p>

    @endif
    <div class="position-relative">
        <a href="{{ route('product', $product->slug) }}" class="d-block">
            <img class="img-fit lazyload mx-auto h-140px h-md-210px"
                src="{{asset('assets')}}/img/placeholder.jpg"
                data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                alt="{{ $product->getTranslation('name') }}"
                onerror="this.onerror=null;this.src='{{asset('assets')}}/img/placeholder.jpg';">
        </a>
        @if ($product->wholesale_product)
            <span class="absolute-bottom-left fs-11 text-white fw-600 px-2 lh-1-8" style="background-color: #455a64">
                {{ __('front.Wholesale') }}
            </span>
        @endif
        <div class="absolute-top-right aiz-p-hov-icon">
            <a href="javascript:void(0)" onclick="addToWishList({{ $product->id }})" data-toggle="tooltip"
                data-title="{{ __('front.Add to wishlist') }}" data-placement="left">
                <i class="la la-heart-o"></i>
            </a>
            <a href="javascript:void(0)" onclick="addToCompare({{ $product->id }})" data-toggle="tooltip"
                data-title="{{ __('front.Add to compare') }}" data-placement="left">
                <i class="las la-sync"></i>
            </a>
            <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})" data-toggle="tooltip"
                data-title="{{ __('front.Add to cart') }}" data-placement="left">
                <i class="las la-shopping-cart"></i>
            </a>
        </div>
    </div>
    <div class="p-md-3 p-2 text-left">
        <div class="fs-15 d-flex justify-content-center align-item-center products-flex">

            <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px">
                <a href="{{ route('product', $product->slug) }}"
                    class="d-block text-reset product-name text-center">{{ $product->getTranslation('name') }}</a>
            </h3>
            <span class="fw-700 text-primary">{{ home_discounted_base_price($product) }}</span>
            @if (home_base_price($product) != home_discounted_base_price($product))
                <del class="fw-600 opacity-50 mr-1">{{ home_base_price($product) }}</del>
            @endif
            <div class="rating rating-sm mt-1">
                {{ renderStarRating($product->rating) }}
            </div>
            @if (addon_is_activated('club_point'))
                <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                    {{ __('front.Club Point') }}:
                    <span class="fw-700 float-right">{{ $product->earn_point }}</span>
                </div>
            @endif
        </div>
    </div>
</div>
