<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CombinedOrder;
use App\Models\BusinessSetting;
use App\Models\Seller;
use Session;
use App\Models\CustomerPackage;
use App\Models\SellerPackage;
use Stripe\Stripe;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Website\CheckoutController;
class StripePaymentController extends Controller
{
    protected $stripe_api_key;
    public function __construct()
    {
        $this->stripe_api_key = env('STRIPE_APIKEY');
    }
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {





//                         $combined_order = CombinedOrder::find(Session::get('combined_order_id'));
//                 $amount =  ceil($combined_order->grand_total);
//               $commission = ($amount * 3) /  100;
//               $total_Amount = $commission + 3 + $amount;

// return  Http::post('https://live.my-compound.com/api/payment', [
//     'payment_type' => 'MASTERCARD',
//     'invoice_id' => $combined_order->id,
//     'amount' => $amount,
//     'total_amount' => $total_Amount,
//     'total_amount_up_amount' => $total_Amount,
//     'commission' => 3,
//     'fixed_amount' => 3,
//     'fees' => 0,
//     'type' => 'invoice'
// ]);


        return view('frontend.payment.stripe');
    }

    public function create_checkout_session(Request $request) {

        $amount = 0;
        if($request->session()->has('payment_type')){
            if($request->session()->get('payment_type') == 'cart_payment'){
                $combined_order = CombinedOrder::findOrFail(Session::get('combined_order_id'));
                $amount = round($combined_order->grand_total * 100);
            }
            elseif ($request->session()->get('payment_type') == 'wallet_payment') {
                $amount = round($request->session()->get('payment_data')['amount'] * 100);
            }
            elseif ($request->session()->get('payment_type') == 'customer_package_payment') {
                $customer_package = CustomerPackage::findOrFail(Session::get('payment_data')['customer_package_id']);
                $amount = round($customer_package->amount * 100);
            }
            elseif ($request->session()->get('payment_type') == 'seller_package_payment') {
                $seller_package = SellerPackage::findOrFail(Session::get('payment_data')['seller_package_id']);
                $amount = round($seller_package->amount * 100);
            }
        }

        \Stripe\Stripe::setApiKey($this->stripe_api_key);

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                    'currency' => \App\Models\Currency::findOrFail(get_setting('system_default_currency'))->code,
                    'product_data' => [
                        'name' => "Payment"
                    ],
                    'unit_amount' => $amount,
                    ],
                    'quantity' => 1,
                    ]
                ],
            'mode' => 'payment',
            'success_url' => route('stripe.success'),
            'cancel_url' => route('stripe.cancel'),
        ]);

        return response()->json(['id' => $session->id, 'status' => 200]);
    }

    public function success() {
        try{
            $payment = ["status" => "Success"];

            $payment_type = Session::get('payment_type');

            if ($payment_type == 'cart_payment') {
                $checkoutController = new CheckoutController;
                return $checkoutController->checkout_done(session()->get('combined_order_id'), json_encode($payment));
            }

            if ($payment_type == 'wallet_payment') {
                $walletController = new WalletController;
                return $walletController->wallet_payment_done(session()->get('payment_data'), json_encode($payment));
            }

            if ($payment_type == 'customer_package_payment') {
                $customer_package_controller = new CustomerPackageController;
                return $customer_package_controller->purchase_payment_done(session()->get('payment_data'), json_encode($payment));
            }
            if($payment_type == 'seller_package_payment') {
                $seller_package_controller = new SellerPackageController;
                return $seller_package_controller->purchase_payment_done(session()->get('payment_data'), json_encode($payment));
            }
        }
        catch (\Exception $e) {
            flash(translate('Payment failed'))->error();
    	    return redirect()->route('home');
        }
    }

    public function cancel(Request $request){
        flash(translate('Payment is cancelled'))->error();
        return redirect()->route('home');
    }
}
