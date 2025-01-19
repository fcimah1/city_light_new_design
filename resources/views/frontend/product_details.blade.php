@extends('frontend.layout')

@php
    $cu = \App\Models\Currency::findOrFail(get_setting('system_default_currency'))->code;
@endphp

@section('meta_title'){{ strtolower($detailedProduct->meta_title) }}@stop

@section('meta_description'){{ $detailedProduct->meta_description }}@stop

@section('meta_keywords'){{ $detailedProduct->tags }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $detailedProduct->meta_title }}">
    <meta itemprop="description" content="{{ $detailedProduct->meta_description }}">
    <meta itemprop="image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $detailedProduct->meta_title }}">
    <meta name="twitter:description" content="{{ $detailedProduct->meta_description }}">
    <meta name="twitter:creator"
        content="@author_handle">
    <meta name="twitter:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">
    <meta name="twitter:data1" content="{{ single_price($detailedProduct->unit_price) }}">
    <meta name="twitter:label1" content="Price">

    <!-- Open Graph data -->




<meta property="og:id" content="{{ $detailedProduct->id }}" />

<meta property="og:title" content="{{ strtolower($detailedProduct->meta_title) }}" >
<meta property="og:description" content="{{ $detailedProduct->meta_description }}" >
<meta property="og:url" content="{{ route('product', $detailedProduct->slug) }}" >
<meta property="og:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}" >
<meta property="og:type" content="og:product" />
<meta property="product:brand" content="{{ $detailedProduct->brand->getTranslation('name') }}">
<meta property="product:availability" content="in stock">
<meta property="product:condition" content="new">
<meta property="og:site_name" content="{{ get_setting('meta_title') }}" />
<meta property="product:price:amount" content="{{ $detailedProduct->unit_price }}">
<meta property="product:price:currency" content="{{ $cu }}">
<meta property="product:retailer_item_id" content="{{ $detailedProduct->id }}">
<meta property="product:item_group_id" content="{{ $detailedProduct->id }}">
<meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
@endsection



@section('content')
 
<div class="products-details">
    <div class="images">
      @php
        $photos = explode(',', $detailedProduct->photos);
      @endphp
      @foreach ($photos as $key => $photo)
          <img id="current_image"
              src=" {{ asset('assets') }}/img/placeholder.jpg"
              {{-- data-src="{{ uploaded_asset($photo) }}" --}}
              class="w-80%"
              onerror="this.onerror=null;this.src='{{ asset('images/fe-1.jpg') }}'">
      @break
      @endforeach
      <div class="all-images mt-5">
        @foreach ($photos as $key => $photo)
          <div class="carousel-box c-pointer border p-1 rounded">
              <img
                  class="lazyload mw-100 size-50px mx-auto"
                  src="{{ asset('images/fe-1.jpg') }}"
                  data-src="{{ uploaded_asset($photo) }}"
                  onerror="this.onerror=null;this.src='{{ asset('images/fe-2.jpg') }}'">
          </div>
        @endforeach
      </div>

      @if (discount_in_percentage($detailedProduct) > 0)
        <span class="discount" dir="ltr"> -{{ discount_in_percentage($detailedProduct) }}%</span>
      @endif
    </div>
    <div class="details">
      <div class="route">
        <a href="{{ url('/') }}"> الرئيسية </a>/ <a href="{{ url()->previous() }}"> {{ $detailedProduct->category->getTranslation('name') }} </a> / {{ $detailedProduct->getTranslation('name') }}</div>
      <h4>{{ $detailedProduct->getTranslation('name') }}</h4>
      @if ($detailedProduct->brand != null)
        <a href="{{ route('products.brand', $detailedProduct->brand->slug) }}">
          <img src="{{ $detailedProduct->brand->getTranslation('logo') != null ? uploaded_asset($detailedProduct->brand->getTranslation('logo')) : asset('images/dlight.png') }}" alt="{{ $detailedProduct->brand->getTranslation('name') }} " />
        </a>
      @endif
      <div class="price">
        <p>
          @if (home_base_price($detailedProduct) != home_discounted_base_price($detailedProduct))
            <span class="price"> {{ home_discounted_base_price($detailedProduct) }} </span> 
            <del>{{ home_base_price($detailedProduct) }} </del>
          @else
            <span class="price"> {{ home_base_price($detailedProduct) }} </span> 
          @endif
      </div>
      <ul class="features-prod">
        @if($detailedProduct->meta_description != null) 
        <li>
          {{ $detailedProduct->meta_description }}
        </li>
        @endif
        <li>ضمان سنة من سيتى لايت ضد عيوب الصناعة.</li>
        <li>استرجاع مجاني خلال ١٤ يوم من تاريخ الاستلام.</li>
        <li>سعر المنتج لا يشمل اللمبات.</li>
      </ul>
      @php
        $qty = 0;
        foreach ($detailedProduct->stocks as $key => $stock) {
          $qty += $stock->qty;
        }
      @endphp
        @if ($detailedProduct->stock_visibility_state == 'quantity')
            <div class="availability" id="available-quantity"><i class="fa-solid fa-check"></i> {{ translate('متوفر') }} ({{ $qty }})</div>
        @elseif($detailedProduct->stock_visibility_state == 'text' && $qty >= 1)
            <div class="availability" id="available-quantity"><i class="fa-solid fa-check"></i> {{ translate('In Stock') }}</div>
        @endif


        <form id="option-choice-form">
            @csrf
            <input type="hidden" name="id" value="{{ $detailedProduct->id }}">

            @if ($detailedProduct->choice_options != null)
                @foreach (json_decode($detailedProduct->choice_options) as $key => $choice)

                    <div class="row no-gutters">
                        <div class="col-sm-2">
                            <div class="opacity-50 my-2">{{ \App\Models\Attribute::find($choice->attribute_id)->getTranslation('name') }}:</div>
                        </div>
                        <div class="col-sm-10">
                            <div class="aiz-radio-inline">
                                @foreach ($choice->values as $key => $value)
                                    <label class="aiz-megabox pl-0 mr-2">
                                        <input
                                            type="radio"
                                            name="attribute_id_{{ $choice->attribute_id }}"
                                            value="{{ $value }}" @if ($key == 0) checked @endif>
                                        <span class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center py-2 px-3 mb-2">
                                          {{ $value }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                @endforeach
            @endif


            @if (count(json_decode($detailedProduct->colors)) > 0)
              <div class="row no-gutters">
                <div class="col-2">
                  <div class="opacity-50 mt-2">{{ __('اللون') }}:</div>
                </div>
                <div class="col-10">
                  <div class="aiz-radio-inline flex">
                    @foreach (json_decode($detailedProduct->colors) as $key => $color)
                      @php
                        $colorName = \App\Models\Color::where('code', $color)->first()->name;
                      @endphp
                      <label class="aiz-megabox pl-0 mr-2 flex" data-toggle="tooltip"
                             data-title="{{ $colorName }}">
                      <input type="radio" name="color"
                             value="{{ $colorName }}"
                             @if ($key == 0) checked @endif>
                      <span
                          class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center p-1 mb-2">

                        @foreach ($detailedProduct->stocks as $stock)
                        @if ($stock->variant == $colorName)
                          <img
                            class="lazyload mw-100 size-80px mx-auto" style="position: static;"
                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                            data-src="{{ uploaded_asset($stock->image) }}"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                        @endif
                        @endforeach
                      </span>
                      </label>
                    @endforeach
                  </div>
                </div>
              </div>
            @endif
            <div class="row no-gutters pb-3 amount">
              <div class="counter  aiz-plus-minus  w-auto">
                <button  type="button" data-type="minus" data-field="quantity" onclick="getVariantPrice()">-</button>
                <input type="number" name="quantity" style="text-align: center;" class="col border-0 text-center flex-grow-1 fs-16 input-number" placeholder="1" value="{{ $detailedProduct->min_qty }}" min="{{ $detailedProduct->min_qty }}" max="10">
                <button  type="button" data-type="plus" data-field="quantity" onclick="getVariantPrice()">+</button>
              </div>
            </div>
        </form>
        
      <div class="amount">
          @if ($qty < $detailedProduct->min_qty)
              <button type="button" class="out-of-stock" disabled>
                <i class="la la-cart-arrow-down"></i> {{ translate('Out of Stock')}}
            </button>
          @else
              <button type="button" class="add-to-cart" onclick="addToCart()">اضف الى السله</button>
              <button type="button" class="buy-now" onclick="buyNow()">اشترى الان</button>
          @endif
        </div>

      <div class="add-fav">
       <a href="#" class="buy-now" onclick="addToWishList({{ $detailedProduct->id }})"> <i class="fa-solid fa-heart heart"></i>أضف الى التفضبلات</a>
      </div>
      <div class="small-details">
        <p>كود المنتج: <span>{{ $detailedProduct->barcode }}</span></p>
        <p>القسم: {{ $detailedProduct->category->getTranslation('name') }}</p>
        <div class="socail">
          <p>تابعنا:</p>
          
          <a href=""><i class="fa-brands fa-facebook-f"></i></a>
          <a href=""><i class="fa-brands fa-instagram"></i></a>
          <a href=""><i class="fa-brands fa-tiktok"></i></a>
        </div>
      </div>
    </div>
  </div>
  <div class="description-details">
    <details class="rules-container description-info">
      <summary>الوصف</summary>

      <p>
        {{ $detailedProduct->category->getTranslation('name') }}
      </p>

      <ul>
      @if (count(json_decode($detailedProduct->colors)) > 0)
        <div class="row no-gutters">
          <li class=" col-2">اللون:                                   
            <div class="col-10">
                <div class="aiz-radio-inline">
                    @foreach (json_decode($detailedProduct->colors) as $key => $color)
                      @php
                          $colorName = \App\Models\Color::where('code', $color)->first();
                      @endphp
                      <div style="text-align: center; display: inline-block; margin:0 10px 10px; width: 100px; height: 20px; background-color: {{ $colorName->code }}">{{ $colorName->name }}</div>
                    @endforeach
                </div>
            </div>
          </li>
        </div>
        <hr> @endif
          {{ $detailedProduct->getTranslation('description') }}

        {{-- <li>الطراز: عتيق</li> --}}
        {{-- <li>الغرفة: غرفة المعيشة | صالون</li>
        <li>نوع اللمبه: E14</li>
        <li>عدد اللمبات: 12</li>
        <li>بلد المنشأ: مصر</li> --}}
      </ul>
    </details>
    <details class="rules-container
        more-info">
    <summary>معلومات إضافية</summary>
    <ul>
        <li><span>الوزن</span>
          <span dir="ltr">{{ $detailedProduct->unit }}</span>
        </li>
      {{-- <li><span>الطراز</span><span>عتيق</span></li>
      <li><span>اللون</span><span>أبيض</span></li>
      <li><span>الماركة</span><span>Le Bronze</span></li>
  </ul> --}}
    </details>

    <details class="rules-container product-rating">
      @php
      $total = 0;
      $total += $detailedProduct->reviews->count();
      @endphp
        <summary>التقييمات <span>{{ $total }}</span></summary>
        <div class="head-rating">
          @if ($total > 0)
            <p>{{ renderStarRating($detailedProduct->rating) }}</p>
            @else
            <p>لا توجد تقييمات بعد</p>
            @endif
            @auth
            <p>كن أول من يقيم</p>
            @else
              <a href="{{ route('login') }}">{{ __('front.You must be logged in to post a review') }}.</a> @endauth
        </div>
    </details>
    </div>

    <div class="related-products">
    <p>منتجات ذات صلة</p>
    <div class="products" id="product-cat">
        @foreach (filter_products(\App\Models\Product::where('user_id', $detailedProduct->user_id)->orderBy('num_of_sale', 'desc'))->limit(4)->get() as $key => $top_product)
            @include('frontend.product.product', ['product' => $top_product])
        @endforeach

    </div>
    </div>

@endsection



<script type="text/javascript" src="{{static_asset('asset/js/jquery-3.3.1.min.js')}}"></script>


    </script>