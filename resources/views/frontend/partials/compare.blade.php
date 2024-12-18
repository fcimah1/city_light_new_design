<a href="#" class="d-flex align-items-center text-reset">
    <i class="la la-refresh la-2x opacity-80"></i>
    <span class="flex-grow-1 ml-1">
        @if (Auth::check())
            <span class="badge badge-primary badge-inline badge-pill">{{ count(Auth::user()->compares) }}</span>
        @else
            <span class="badge badge-primary badge-inline badge-pill">0</span>
        @endif
        <span class="nav-box-text d-none d-xl-block opacity-70">{{ __('front.Compare') }}</span>
    </span>
</a>
