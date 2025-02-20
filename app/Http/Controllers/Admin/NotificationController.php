<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

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
            return view('frontend.user.seller.notification.index', compact('notifications'));
        }

        if(Auth::user()->user_type == 'customer') {
            return view('frontend.user.customer.notification.index', compact('notifications'));
        }

    }
}
