<?php

namespace App\Providers;

use Barryvdh\LaravelIdeHelper\Console\EloquentCommand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AliasServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('PaytmWallet', \Anand\LaravelPaytmWallet\Facades\PaytmWallet::class);
        $loader->alias('App', \Illuminate\Support\Facades\App::class);
        $loader->alias('Arr', Arr::class);
        $loader->alias('Artisan', Artisan::class);
        $loader->alias('Auth', Auth::class);
        $loader->alias('Blade',Blade::class);
        $loader->alias('Broadcast', Broadcast::class);
        $loader->alias('Cache', Cache::class);
        $loader->alias('Config', Config::class);
        $loader->alias('Cookie', Cookie::class);
        $loader->alias('Crypt', Crypt::class);
        $loader->alias('Eloquent', Model::class);
        $loader->alias('Event', Event::class);
        $loader->alias('File', File::class);
        $loader->alias('Gate', Gate::class);
        $loader->alias('Hash', Hash::class);
        $loader->alias('Http', Http::class);
        $loader->alias('Lang', Lang::class);
        $loader->alias('Log', Log::class);
        $loader->alias('Mail', Mail::class);
        $loader->alias('Notification', Notification::class);
        $loader->alias('Password', Password::class);
        $loader->alias('Queue', Queue::class);
        $loader->alias('Redirect', Redirect::class);
        $loader->alias('Redis', Redis::class);
        $loader->alias('Request', Request::class);
        $loader->alias('Response', Response::class);
        $loader->alias('Route', Route::class);
        $loader->alias('Schema', Schema::class);
        $loader->alias('Session', Session::class);
        $loader->alias('Storage', Storage::class);
        $loader->alias('Bus', Bus::class);
        $loader->alias('Str', \Illuminate\Support\Str::class);
        $loader->alias('URL', URL::class);
        $loader->alias('Validator', Validator::class);
        $loader->alias('View', View::class);
        
        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
