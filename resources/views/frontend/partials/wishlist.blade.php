@if (Auth::check())

<a href="{{ route('wishlists.index') }}" class="d-flex align-items-center text-reset">
{{--    <i class="la la-heart-o la-2x opacity-80"></i>--}}
    <i class=" icon_heart_alt  la-2x" ></i>
    <span style="height: 0px; right: -5px;">

            <span class="badge badge-primary badge-inline badge-pill">{{ count(Auth::user()->wishlists) }}</span>


    </span>
</a>
@else
    <a href="#" class="d-flex align-items-center text-reset"
            onclick="showCheckoutModal()">

        <i class=" icon_heart_alt  la-2x" ></i>
        <span style="height: 0px; right: -5px;">

                <span class="badge badge-primary badge-inline ">0</span>


        </span>
    </a>

@endif
