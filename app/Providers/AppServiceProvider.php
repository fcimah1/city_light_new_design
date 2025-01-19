<?php

namespace App\Providers;

use Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        App::setLocale('en');
        Paginator::useBootstrap();
        View::composer('*', function ($view) {
            $totalCart = 0;
            $cartCount = 0;
            $wishlistCount = 0;
            $cart = [];
            if (Auth::user() != null) {
                $user_id = Auth::user()->id;
                $cart = \App\Models\Cart::where('user_id', $user_id)->get();
            } else {
            $temp_user_id = Session()->get('temp_user_id');
                if ($temp_user_id) {
                    $cart = \App\Models\Cart::where('temp_user_id', $temp_user_id)->get();
                }
            }
            if (isset($cart) && count($cart) > 0) {
                foreach ($cart as $key => $cartItem) {
                    $totalCart = $totalCart + $cartItem['price'] * $cartItem['quantity'];
                }
            }
            if(isset($cart) && count($cart) > 0){
                $cartCount = count($cart);
            }

            if(Auth::check()){
                $wishlistCount = \App\Models\Wishlist::where('user_id', Auth::id())->count();
            }
            $view->with(compact('cartCount', 'wishlistCount', 'totalCart'));
        });
    }
}
