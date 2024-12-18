<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Website\Controller;
use Illuminate\Http\Request;
use Auth;

class NotificationController extends Controller
{
    public function index() {
        $notifications = auth()->user()->notifications()->paginate(15);

        auth()->user()->unreadNotifications->markAsRead();

        if(Auth::user()->user_type == 'admin') {
            return view('backend.notification.index', compact('notifications'));
        }

        if(Auth::user()->user_type == 'seller') {
            return view('front.user.seller.notification.index', compact('notifications'));
        }

        if(Auth::user()->user_type == 'customer') {
            return view('front.user.customer.notification.index', compact('notifications'));
        }

    }
}
