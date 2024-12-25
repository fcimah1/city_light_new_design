@extends('frontend.layout')

@section('content')
    <div class="cat-landing">
        <p>ثريات</p>
    </div>

    <div class="cat-content">
        <div id="layer-filter-product" class="layer"></div>
        <div class="right" id="filter-menu">
            <div class="price-slider">
                <h5>
                    <span id="close-btn-filter"><i class="fa-solid fa-xmark"></i>اغلق</span>
                </h5>
                <h4>تصفية حسب السعر</h4>
                <div class="price-content">
                    <label for="">السعر</label>
                    <p id="min-value">$50</p>
                    -
                    <p id="max-value">$500</p>
                </div>
                <div class="range-slider" dir="ltr">
                    <div class="range-fill" id="range-slider-id"></div>

                    <input type="range" class="min-price" value="100" min="10" max="500" step="10" />

                    <input type="range" class="max-price" value="250" min="10" max="500" step="10" />
                </div>
            </div>
            <div class="brand-filter">
                <p>تصفية حسب الماركة</p>
                <div class="search">
                    <input type="text" name="brand" placeholder="ابحث عن الماركه" />
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <div class="brands">
                    @foreach ($brands as $brand)
                        <div class="brand">
                            <label>
                                <input type="checkbox" />
                                {{ $brand->name }}
                            </label>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="btn">
                <button>تصفية</button>
            </div>
        </div>
        <div class="left">
            <div class="head">
                <div class="route">
                    <div class="main-route">الرئسيه</div>
                    /
                    <div class="category">ثريات</div>
                </div>

                <div class="sub-filter">
                    <div class="grid-3" id="btn-grid-3">
                        <span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>
                    </div>
                    <div class="grid-4" id="btn-grid-4">
                        <span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>
                    </div>

                    <select name="" id="">
                        <option value="">ترتيب بالاكثر مبيعا</option>
                        <option value="">ترتيب بتقيم العملاء</option>
                        <option value="">ترتيب حسب الاحدث</option>
                        <option value="">ترتيب حسب الاحدث</option>
                        <option value="">ترتيب حسب السعر الأقل</option>
                        <option value="">ترتيب حسب السعر الأعلى</option>
                    </select>
                </div>
            </div>
            <div class="filter-btn-small-screen">
                <button id="btn-toggle-filter" data-expanded="false">
                    <p>التصفيات</p>
                    <span class="nav-toggler-icon"> </span>
                </button>
            </div>
            <div class="products" id="product-cat">
                @foreach ($products as $product)
                <div class="box">
                    <div class="image">
                        <a href="{{route('product', $product->slug)}}">
                        <img
                            class="img-fit lazyload mx-auto h-310px h-md-310px"
                            src="{{asset('assets')}}/img/placeholder.jpg"
                            data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                            alt=" product image {{ $product->getTranslation('name') }}"
                            onerror="this.onerror=null;this.src='{{asset('images/fe-1.jpg')}}">
                        </a>
                        @if (discount_in_percentage($product) > 0)
                            <span class="discount"> {{discount_in_percentage($product)}}%</span>
                        @endif
                        <i class="fa-solid fa-heart heart"></i>
                        <i class="fa-solid fa-magnifying-glass quick-look"></i>
          
                    </div>
                    <p>{{ $product->getTranslation('name') }}</p>
                    <p>
                        <span class="total">
                            <bdo dir="ltr">
                                @if (home_base_price($product) != home_discounted_base_price($product))
                                    <span class="price"> {{ home_discounted_base_price($product) }} </span> 
                                    <del>{{ home_base_price($product) }} </del>
                                @else
                                    <span class="price"> {{ home_base_price($product) }} </span> 
                                @endif
                                
                            </bdo></span>
                    </p>
                    <button>اضف الى السله</button>
                </div>
                @endforeach

                <div class="box">
                    <div class="image">
                        <a href="product-detalis.html"><img src="{{ asset('images/fe-2.jpg') }}" alt="" /></a>
                        <span class="discount"> -34%</span>
                        <i class="fa-solid fa-heart heart"></i>
                        <i class="fa-solid fa-magnifying-glass quick-look"></i>
                    </div>
                    <p>أباجورة تيمورا 1 لمبة أسود</p>
                    <p>
                        <span class="total"><bdo dir="ltr"><span class="price"> 747 EGP</span> <del>1,099
                                    EGP</del></bdo></span>
                    </p>
                    <button>اضف الى السله</button>
                </div>
                <div class="box">
                    <div class="image">
                        <a href="product-detalis.html"><img src="{{ asset('images/fe-3.jpg') }}" alt="" /></a>
                        <span class="discount"> -34%</span>
                        <i class="fa-solid fa-heart heart"></i>
                        <i class="fa-solid fa-magnifying-glass quick-look"></i>
                    </div>
                    <p>أباجورة تيمورا 1 لمبة أسود</p>
                    <p>
                        <span class="total"><bdo dir="ltr"><span class="price"> 747 EGP</span> <del>1,099
                                    EGP</del></bdo></span>
                    </p>
                    <button>اضف الى السله</button>
                </div>
                <div class="box">
                    <div class="image">
                        <a href="product-detalis.html"><img src="{{ asset('images/fe-1.jpg') }}" alt="" /></a>
                        <span class="discount"> -34%</span>
                        <i class="fa-solid fa-heart heart"></i>
                        <i class="fa-solid fa-magnifying-glass quick-look"></i>
                    </div>
                    <p>أباجورة تيمورا 1 لمبة أسود</p>
                    <p>
                        <span class="total"><bdo dir="ltr"><span class="price"> 747 EGP</span> <del>1,099
                                    EGP</del></bdo></span>
                    </p>
                    <button>اضف الى السله</button>
                </div>
                <div class="box">
                    <div class="image">
                        <a href="product-detalis.html"><img src="{{ asset('images/fe-2.jpg') }}" alt="" /></a>
                        <span class="discount"> -34%</span>
                        <i class="fa-solid fa-heart heart"></i>
                        <i class="fa-solid fa-magnifying-glass quick-look"></i>
                    </div>
                    <p>أباجورة تيمورا 1 لمبة أسود</p>
                    <p>
                        <span class="total"><bdo dir="ltr"><span class="price"> 747 EGP</span> <del>1,099
                                    EGP</del></bdo></span>
                    </p>
                    <button>اضف الى السله</button>
                </div>
                <div class="box">
                    <div class="image">
                        <a href="product-detalis.html"><img src="{{ asset('images/fe-3.jpg') }}" alt="" /></a>
                        <span class="discount"> -34%</span>
                        <i class="fa-solid fa-heart heart"></i>
                        <i class="fa-solid fa-magnifying-glass quick-look"></i>
                    </div>
                    <p>أباجورة تيمورا 1 لمبة أسود</p>
                    <p>
                        <span class="total"><bdo dir="ltr"><span class="price"> 747 EGP</span> <del>1,099
                                    EGP</del></bdo></span>
                    </p>
                    <button>اضف الى السله</button>
                </div>
                <div class="box">
                    <div class="image">
                        <a href="product-detalis.html"><img src="{{ asset('images/fe-2.jpg') }}" alt="" /></a>
                        <span class="discount"> -34%</span>
                        <i class="fa-solid fa-heart heart"></i>
                        <i class="fa-solid fa-magnifying-glass quick-look"></i>
                    </div>
                    <p>أباجورة تيمورا 1 لمبة أسود</p>
                    <p>
                        <span class="total"><bdo dir="ltr"><span class="price"> 747 EGP</span> <del>1,099
                                    EGP</del></bdo></span>
                    </p>
                    <button>اضف الى السله</button>
                </div>
                <div class="box">
                    <div class="image">
                        <a href="product-detalis.html"><img src="{{ asset('images/fe-3.jpg') }}" alt="" /></a>
                        <span class="discount"> -34%</span>
                        <i class="fa-solid fa-heart heart"></i>
                        <i class="fa-solid fa-magnifying-glass quick-look"></i>
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

    <!-- Start Popup details -->
    <div class="popup-container" id="popup-quick">
        <div id="layer-popup" class="layer"></div>
        <div class="popup">
          <div class="images">
            <img src="{{asset('images/1090010001151009-1.jpg')}}" alt="" />
            <button>view details</button>
          </div>
          <div class="details">
            <h4>ثريا بومب 16 لمبة ذهبي</h4>
            <img src="{{asset('images/dlight.png')}}" alt="brand-image" />
            <div class="rating">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
  
              <i class="fa-regular fa-star"></i>
              <p>( <span>1</span>تقييم العملاء )</p>
            </div>
            <div class="price">
              <p><del>817 ر.س</del> <span>480 ر.س</span></p>
            </div>
            <ul class="features-prod">
              <li>ضمان سنة من سيتى لايت ضد عيوب الصناعة.</li>
              <li>استرجاع مجاني خلال ١٤ يوم من تاريخ الاستلام.</li>
              <li>سعر المنتج لا يشمل اللمبات.</li>
            </ul>
  
            <div class="availability"><i class="fa-solid fa-check"></i>متوفر</div>
  
            <div class="amount">
              <div class="counter">
                <button id="popup-decrement">-</button>
                <p id="popup-count">1</p>
                <button id="popup-increment">+</button>
              </div>
              <button>اضف الى السله</button>
            </div>
          </div>
        </div>
      </div>
    <!-- End Popup details -->
@endsection
