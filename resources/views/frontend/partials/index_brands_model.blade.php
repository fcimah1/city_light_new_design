
@foreach($brands as $brand)
<div class="product-item">
            <div class="pi-pic">
                    <a href="{{url('brand')}}/{{$brand->slug}}">
                        <img  class="lazyload   w-390px h-240px h-md-240px"
                                        src="{{asset('assets')}}/img/placeholder.jpg"
                                        data-src="{{ uploaded_asset($brand->banner) }}"
                                        alt=" {{$brand->slug}} "
                                        onerror="this.onerror=null;this.src='{{asset('assets')}}/img/placeholder.jpg';">


                    </a>
            </div>
        <div class="pi-text mx-auto mx-auto">
        <div class="catagory-name">{{$brand->getTranslation('name')}}</div>



    </div>
        </div>
@endforeach




