<div class="modal-body p-4 added-to-cart">
    <div class="text-center text-success mb-4">
        <i class="las la-check-circle la-3x"></i>
        <h3>{{ __('تم اضافة المنتج الى السله !') }}</h3>
    </div>
    <div class="media mb-4">
        <img src="{{asset('assets')}}/img/placeholder.jpg"
            data-src="{{ uploaded_asset($product->thumbnail_img) }}" class="mr-3 lazyload size-100px img-fit rounded"
            onerror="this.onerror=null;this.src='{{ asset('images/fe-3.jpg') }}'"
            alt="Product Image">
        <div class="media-body pt-3 mx-3">
            <strong class="fw-600">
                {{ $product->getTranslation('name') }}
            </strong>
            <div class="row mt-3">
                <div class="col-sm-2 opacity-60">
                    <div>{{ __('السعر') }}:</div>
                </div>
                <div class="col-sm-10">
                    <div class=" text-primary">
                        <strong>
                            {{ single_price(($data['price'] + $data['tax']) * $data['quantity']) }}
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        <button class="btn btn-outline-primary mb-3 mb-sm-0"
            data-dismiss="modal">{{ __('العوده الى التسوق') }}</button>
        <a href="{{ route('cart') }}" class="btn btn-primary mb-3 mb-sm-0">{{ __('الذهاب الى الشراء') }}</a>
    </div>
</div>
