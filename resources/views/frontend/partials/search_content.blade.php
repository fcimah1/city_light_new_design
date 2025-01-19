<div class="">
    @if (sizeof($keywords) > 0)
        <div class="px-2 py-1 text-uppercase fs-10 text-right text-muted bg-soft-secondary">
            {{ __('front.Popular Suggestions') }}</div>
        <ul class="list-group list-group-raw">
            @foreach ($keywords as $key => $keyword)
                <li class="list-group-item py-1">
                    <a class="text-reset hov-text-primary"
                        href="{{ route('suggestion.search', $keyword) }}">{{ $keyword }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
<div class="">
    @if (count($categories) > 0)
        <div class="px-2 py-1 text-uppercase fs-10 text-right text-muted bg-soft-secondary">
            {{ __('front.Category Suggestions') }}</div>
        <ul class="list-group list-group-raw">
            @foreach ($categories as $key => $category)
                <li class="list-group-item py-1">
                    <a class="text-reset hov-text-primary"
                        href="{{ route('products.category', $category->slug) }}">{{ $category->getTranslation('name') }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
<div class="">
    @if (count($products) > 0)
        <div class="px-2 py-1 text-uppercase fs-10 text-right text-muted bg-soft-secondary">{{ __('front.Products') }}
        </div>
        <ul class="list-group list-group-raw">
            @foreach ($products as $key => $product)
                <li class="list-group-item">
                    <div style="float: right">
                        <a href="javascript:void(0)" class="btn btn-soft-primary mr-2 add-to-cart fw-600" onclick="showAddToCartModal({{ $product->id }})" data-toggle="tooltip"
                           data-title="{{ __('front.Add to cart') }}" data-placement="right">
                            <i class="las la-shopping-cart"></i>
                        </a>
                    </div>
                    <a class="text-reset" href="{{ route('product', $product->slug) }}">
                        <div class="d-flex search-product align-items-center">
                            <div class="mr-3">
                                <img class="size-40px img-fit rounded lazyload"


                                     src="{{asset('assets')}}/img/placeholder.jpg"
                                     data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                     onerror="this.onerror=null;this.src='{{asset('assets')}}/img/placeholder.jpg';">


                            </div>
                            <div class="flex-grow-1 overflow--hidden minw-0">
                                <div class="product-name text-truncate fs-14 mb-5px">
                                    {{ $product->getTranslation('name') }}

                                </div>
                                <div class="">
                                    @if (home_base_price($product) != home_discounted_base_price($product))
                                        <del class="opacity-60 fs-15">{{ home_base_price($product) }}</del>
                                    @endif
                                    <span
                                        class="fw-600 fs-16 text-primary">{{ home_discounted_base_price($product) }}</span>
                                </div>
                            </div>


                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
