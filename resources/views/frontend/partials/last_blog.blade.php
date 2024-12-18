
<div class="mb-4">
    <div class="container">
        <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
            <div class="d-flex mb-3 align-items-baseline border-bottom">

                <h3 class="h5 fw-700 mb-0">
                    <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('New Blogs')}}</span>
                </h3>
                <a href="{{ route('blog') }}" class="ml-auto mr-0 btn btn-primary btn-sm shadow-md">{{ translate('View All Blogs') }}</a>

            </div>

            <div class="card-columns">
                @foreach($blogs as $blog)
                    <div class="card mb-3 overflow-hidden shadow-sm">
                        <a href="{{ url("blog").'/'. $blog->slug }}" class="text-reset d-block">
                            <img
                                src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                data-src="{{ uploaded_asset($blog->banner) }}"
                                alt="{{ $blog->title }}"
                                class="img-fluid lazyload "
                            >
                        </a>
                        <div class="p-4">
                            <h2 class="fs-18 fw-600 mb-1">
                                <a href="{{ url("blog").'/'. $blog->slug }}" class="text-reset">
                                    {{ $blog->title }}
                                </a>
                            </h2>
                            @if($blog->category != null)
                                <div class="mb-2 opacity-50">
                                    <i>{{ $blog->category->category_name }}</i>
                                </div>
                            @endif
                            <p class="opacity-70 mb-4">
                                {{ $blog->short_description }}
                            </p>
                            <a href="{{ url("blog").'/'. $blog->slug }}" class="btn btn-soft-primary">
                                {{ translate('View More') }}
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>






    </div>
</div>
