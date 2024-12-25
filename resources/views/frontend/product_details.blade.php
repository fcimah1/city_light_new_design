@extends('frontend.layout')

@php
$cu =  \App\Models\Currency::findOrFail(get_setting('system_default_currency'))->code ;
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
    <meta name="twitter:creator" content="@author_handle">
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
<meta property="product:price:amount" content="{{$detailedProduct->unit_price}}">
<meta property="product:price:currency" content="{{$cu}}">
<meta property="product:retailer_item_id" content="{{$detailedProduct->id}}">
<meta property="product:item_group_id" content="{{$detailedProduct->id}}">
<meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
@endsection



@section('content')
 
<div class="products-details">
    <div class="images">
      <img src="{{asset('images/details-1.jpg')}}" alt="" />
      <div class="all-images">
        <img src="{{asset('images/details-1.jpg')}}" alt="" />
        <img src="{{asset('images/details-2.jpg')}}" alt="" />
        <img src="{{asset('images/details-3.jpg')}}" alt="" />
      </div>
      @if (discount_in_percentage($detailedProduct) > 0)
        <span class="discount" dir="ltr"> -{{discount_in_percentage($detailedProduct)}}%</span>
      @endif
    </div>
    <div class="details">
        @php
            // $categoryName = \App\Models\Category::findOrFail($detailedProduct->category_id)->getTranslation('name');

        @endphp
      <div class="route">
        <a href="{{url('/')}}"> الرئيسية </a>/ <a href="{{url()->previous()}}"> {{$detailedProduct->category->getTranslation('name')}} </a> / {{$detailedProduct->getTranslation('name')}}</div>
      <h4>{{$detailedProduct->getTranslation('name')}}</h4>
      {{-- <img src="{{asset('images/dlight.png')}}" alt="brand-image" /> --}}
      @if ($detailedProduct->brand != null)
      <a href="{{ route('products.brand',$detailedProduct->brand->slug) }}">
      <img src="{{uploaded_asset($detailedProduct->brand->getTranslation('logo'))}}" alt="{{$detailedProduct->brand->getTranslation('name')}} " />
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
        <li>ضمان سنة من سيتى لايت ضد عيوب الصناعة.</li>
        <li>استرجاع مجاني خلال ١٤ يوم من تاريخ الاستلام.</li>
        <li>سعر المنتج لا يشمل اللمبات.</li>
      </ul>

        @if($detailedProduct->stock_visibility_state == 'quantity')
            <div class="availability" id="available-quantity"><i class="fa-solid fa-check"></i> {{ translate('متوفر')}}</div>
        @elseif($detailedProduct->stock_visibility_state == 'text' && $qty >= 1)
            <div class="availability" id="available-quantity"><i class="fa-solid fa-check"></i> {{ translate('In Stock') }}</div>
        @endif

      <div class="amount">
        <div class="counter">
          <button id="popup-decrement">-</button>
          <p id="popup-count">1</p>
          <button id="popup-increment">+</button>
        </div>
        <button>اضف الى السله</button>
      </div>

      <div class="add-fav">
        <i class="fa-solid fa-heart heart"></i>أضف الى التفضبلات
      </div>
      <div class="small-details">
        <p>كود المنتج: <span>{{$detailedProduct->barcode}}</span></p>
        <p>القسم: {{$detailedProduct->category->getTranslation('name')}}</p>
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
        {{$detailedProduct->category->getTranslation('name')}}
      </p>

      <ul>
        @if (count(json_decode($detailedProduct->colors)) > 0)
                                    <div class="row no-gutters">
                                        <div class="col-2">
                                            <div class="opacity-50 mt-2">{{ __('front.Color') }}:</div>
                                        </div>
                                        <div class="col-10">
                                            <div class="aiz-radio-inline">
                                                @foreach (json_decode($detailedProduct->colors) as $key => $color)
                                                    @php
                                                        $colorName = \App\Models\Color::where('code', $color)->first()->name;
                                                    @endphp
                                                    <label class="aiz-megabox pl-0 mr-2" data-toggle="tooltip"
                                                           data-title="{{ $colorName }}">
                                                        <input type="radio" name="color"
                                                               value="{{ $colorName }}"
                                                               @if ($key == 0) checked @endif>
                                                        <span
                                                            class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center p-1 mb-2">

                                                            @foreach($detailedProduct->stocks as $stock)
                                                                @if($stock->variant == $colorName)
                                                                    <img
                                                                        class="lazyload mw-100 size-80px mx-auto"
                                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                                        data-src="{{ uploaded_asset($stock->image) }}"
                                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                                    >
                                                                @endif
                                                            @endforeach


                                                        </span>



                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                            @endif
        <li>اللون: أبيض</li>
        <li>الطراز: عتيق</li>
        <li>الغرفة: غرفة المعيشة | صالون</li>
        <li>نوع اللمبه: E14</li>
        <li>عدد اللمبات: 12</li>
        <li>بلد المنشأ: مصر</li>
      </ul>
    </details>
    <details class="rules-container more-info">
      <summary>معلومات إضافية</summary>
      <ul>
        <li><span>الوزن</span><span dir="ltr">kg 16.8</span></li>
        <li><span>الطراز</span><span>عتيق</span></li>
        <li><span>اللون</span><span>أبيض</span></li>
        <li><span>الماركة</span><span>Le Bronze</span></li>
      </ul>
    </details>

    <details class="rules-container product-rating">
      <summary>التقييمات <span>(0)</span></summary>
      <div class="head-rating">
        <p>التقيمات</p>
        <p>كن أول من يقيم</p>
      </div>
      <div class="all-rating">
        <p>لا توجد تقييمات بعد</p>
        <p>You must be logged in to post a review.</p>
      </div>
    </details>
  </div>

  <div class="related-products">
    <p>منتجات ذات صلة</p>
    <div class="products" id="product-cat">
      <div class="box">
        <div class="image">
          <a href="product-detalis.html"
            ><img src="{{asset('images/fe-1.jpg')}}" alt=""
          /></a>
          <span class="discount"> -34%</span>
          <i class="fa-solid fa-heart heart"></i>
          <i class="fa-solid fa-magnifying-glass quick-look"></i>
        </div>
        <p>أباجورة تيمورا 1 لمبة أسود</p>
        <p>
          <span class="total"
            ><bdo dir="ltr"
              ><span class="price"> 747 EGP</span> <del>1,099 EGP</del></bdo
            ></span
          >
        </p>
        <button>اضف الى السله</button>
      </div>
      <div class="box">
        <div class="image">
          <a href="product-detalis.html"
            ><img src="{{asset('images/fe-2.jpg')}}" alt=""
          /></a>
          <span class="discount"> -34%</span>
          <i class="fa-solid fa-heart heart"></i>
          <i class="fa-solid fa-magnifying-glass quick-look"></i>
        </div>
        <p>أباجورة تيمورا 1 لمبة أسود</p>
        <p>
          <span class="total"
            ><bdo dir="ltr"
              ><span class="price"> 747 EGP</span> <del>1,099 EGP</del></bdo
            ></span
          >
        </p>
        <button>اضف الى السله</button>
      </div>
      <div class="box">
        <div class="image">
          <a href="product-detalis.html"
            ><img src="{{asset('images/fe-3.jpg')}}" alt=""
          /></a>
          <span class="discount"> -34%</span>
          <i class="fa-solid fa-heart heart"></i>
          <i class="fa-solid fa-magnifying-glass quick-look"></i>
        </div>
        <p>أباجورة تيمورا 1 لمبة أسود</p>
        <p>
          <span class="total"
            ><bdo dir="ltr"
              ><span class="price"> 747 EGP</span> <del>1,099 EGP</del></bdo
            ></span
          >
        </p>
        <button>اضف الى السله</button>
      </div>
      <div class="box">
        <div class="image">
          <a href="product-detalis.html"
            ><img src="{{asset('images/fe-1.jpg')}}" alt=""
          /></a>
          <span class="discount"> -34%</span>
          <i class="fa-solid fa-heart heart"></i>
          <i class="fa-solid fa-magnifying-glass quick-look"></i>
        </div>
        <p>أباجورة تيمورا 1 لمبة أسود</p>
        <p>
          <span class="total"
            ><bdo dir="ltr"
              ><span class="price"> 747 EGP</span> <del>1,099 EGP</del></bdo
            ></span
          >
        </p>
        <button>اضف الى السله</button>
      </div>
      <div class="box">
        <div class="image">
          <a href="product-detalis.html"
            ><img src="{{asset('images/fe-2.jpg')}}" alt=""
          /></a>
          <span class="discount"> -34%</span>
          <i class="fa-solid fa-heart heart"></i>
          <i class="fa-solid fa-magnifying-glass quick-look"></i>
        </div>
        <p>أباجورة تيمورا 1 لمبة أسود</p>
        <p>
          <span class="total"
            ><bdo dir="ltr"
              ><span class="price"> 747 EGP</span> <del>1,099 EGP</del></bdo
            ></span
          >
        </p>
        <button>اضف الى السله</button>
      </div>
      <div class="box">
        <div class="image">
          <a href="product-detalis.html"
            ><img src="{{asset('images/fe-3.jpg')}}" alt=""
          /></a>
          <span class="discount"> -34%</span>
          <i class="fa-solid fa-heart heart"></i>
          <i class="fa-solid fa-magnifying-glass quick-look"></i>
        </div>
        <p>أباجورة تيمورا 1 لمبة أسود</p>
        <p>
          <span class="total"
            ><bdo dir="ltr"
              ><span class="price"> 747 EGP</span> <del>1,099 EGP</del></bdo
            ></span
          >
        </p>
        <button>اضف الى السله</button>
      </div>
      <div class="box">
        <div class="image">
          <a href="product-detalis.html"
            ><img src="{{asset('images/fe-2.jpg')}}" alt=""
          /></a>
          <span class="discount"> -34%</span>
          <i class="fa-solid fa-heart heart"></i>
          <i class="fa-solid fa-magnifying-glass quick-look"></i>
        </div>
        <p>أباجورة تيمورا 1 لمبة أسود</p>
        <p>
          <span class="total"
            ><bdo dir="ltr"
              ><span class="price"> 747 EGP</span> <del>1,099 EGP</del></bdo
            ></span
          >
        </p>
        <button>اضف الى السله</button>
      </div>
      <div class="box">
        <div class="image">
          <a href="product-detalis.html"
            ><img src="{{asset('images/fe-3.jpg')}}" alt=""
          /></a>
          <span class="discount"> -34%</span>
          <i class="fa-solid fa-heart heart"></i>
          <i class="fa-solid fa-magnifying-glass quick-look"></i>
        </div>
        <p>أباجورة تيمورا 1 لمبة أسود</p>
        <p>
          <span class="total"
            ><bdo dir="ltr"
              ><span class="price"> 747 EGP</span> <del>1,099 EGP</del></bdo
            ></span
          >
        </p>
        <button>اضف الى السله</button>
      </div>
    </div>
  </div>

 @endsection
