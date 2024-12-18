<?php

namespace App\Http\Controllers\Website;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Utility\PayfastUtility;

use App\Http\Controllers\PaypalController;
//use App\Http\Controllers\StripePaymentController;
//use App\Http\Controllers\PublicSslCommerzPaymentController;
//use App\Http\Controllers\InstamojoController;
//use App\Http\Controllers\PaytmController;
use Auth;
use Session;
use App\Models\Wallet;
use App\Utility\PayhereUtility;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = Wallet::where('user_id', Auth::user()->id)->latest()->paginate(9);
        return view('front.user.wallet.index', compact('wallets'));
    }

    public function recharge(Request $request)
    {

        // $request
        $request->validate([
            [
                'amount' => 'required|integer',
                'payment_method' => 'required',
            ]
        ]);
        $data['amount'] = $request->amount;
        $data['payment_method'] = $request->payment_option;



        $request->session()->put('payment_type', 'wallet_payment');
        $request->session()->put('payment_data', $data);

        if ($request->payment_option == 'paypal') {
            $paypal = new PaypalController;
            return $paypal->getCheckout();
        }

        return redirect()->route('wallet.index');
    }

    public function wallet_payment_done($payment_data, $payment_details)
    {
        $user = Auth::user();
        $user->balance = $user->balance + $payment_data['amount'];
        $user->save();

        $wallet = new Wallet;
        $wallet->user_id = $user->id;
        $wallet->amount = $payment_data['amount'];
        $wallet->payment_method = $payment_data['payment_method'];
        $wallet->payment_details = $payment_details;
        $wallet->save();

        Session::forget('payment_data');
        Session::forget('payment_type');

//        flash(__('front.Payment completed'))->success();
        flash('Payment completed')->success();
        return redirect()->route('wallet.index');
    }

    public function offline_recharge(Request $request)
    {
        $wallet = new Wallet;
        $wallet->user_id = Auth::user()->id;
        $wallet->amount = $request->amount;
        $wallet->payment_method = $request->payment_option;
        $wallet->payment_details = $request->trx_id;
        $wallet->approval = 0;
        $wallet->offline_payment = 1;
        $wallet->reciept = $request->photo;
        $wallet->save();
        flash(__('front.Offline Recharge has been done. Please wait for response.'))->success();
        return redirect()->route('wallet.index');
    }

    public function offline_recharge_request()
    {
        $wallets = Wallet::where('offline_payment', 1)->paginate(10);
        return view('manual_payment_methods.wallet_request', compact('wallets'));
    }

    public function updateApproved(Request $request)
    {
        $wallet = Wallet::findOrFail($request->id);
        $wallet->approval = $request->status;
        if ($request->status == 1) {
            $user = $wallet->user;
            $user->balance = $user->balance + $wallet->amount;
            $user->save();
        } else {
            $user = $wallet->user;
            $user->balance = $user->balance - $wallet->amount;
            $user->save();
        }
        if ($wallet->save()) {
            return 1;
        }
        return 0;
    }
}
