
<div class="icons">
    <div class="cart" id="cart">
        <span>
            <span class="price" id="cart-total">
                {{ $totalCart }}
            </span>
            ر.س
        </span>
        <span class="top">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="cart-count" id="cart_count">{{ $cartCount }}</span>
        </span>
    </div>
    @if(Auth::check())
    <a href="{{route('wishlists.index')}}" class="top">
        <i class="fa-solid fa-heart heart"></i>
        <span class="cart-count" id="wishlist-count">{{ $wishlistCount }}</span>
    </a>
    @else
    <span href="" class="top" id="user-login">
        <i class="fa-solid fa-heart heart"></i>
        <span class="cart-count" id="wishlist-count">{{ $wishlistCount }}</span>
    </span>
    @endif
</div>

