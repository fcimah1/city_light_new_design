<?php
namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Auth\RegisterController;

use Illuminate\Http\Request;
use Auth;
use App\Models\Category;
use App\Models\Cart;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\Website\OrderController;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Address;
use App\Models\CombinedOrder;
use Session;
use App\Utility\PayhereUtility;
use App\Utility\NotificationUtility;

class CheckoutController extends Controller
{
    private  $design;
    public function __construct()
    {

        $this->design = 'frontend';
    }

    //check the selected payment gateway and redirect to that controller accordingly
    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            $user = new RegisterController;
            $request->merge(['password' => '12345678']);
            $user->register($request);
            $user = Auth::user();
        }
        if(Auth::id() == null){
            flash(translate('Email or Phone already exists.'));
                return back();
        }
        
        $address = new AddressController;
        $address->store($request);
        
        $address_id = Address::where('user_id', Auth::user()->id)->latest()->first()->id;
        $carts = $this->store_shipping_info($address_id);

        if ($request->payment_option != null) {
            (new OrderController)->store($request);
            $request->session()->put('payment_type', 'cart_payment');

            if ($request->session()->get('combined_order_id') != null) {

                if ($request->payment_option == 'paypal') {
                    $paypal = new PaypalController;
                    return $paypal->getCheckout();
                } elseif ($request->payment_option == 'stripe') {

                    $stripe = new StripePaymentController;
                    return $stripe->stripe();
                } elseif ($request->payment_option == 'payhere') {
                    $combined_order = CombinedOrder::findOrFail($request->session()->get('combined_order_id'));

                    $combined_order_id = $combined_order->id;
                    $amount = $combined_order->grand_total;
                    $first_name = json_decode($combined_order->shipping_address)->name;
                    $last_name = 'X';
                    $phone = json_decode($combined_order->shipping_address)->phone;
                    $email = json_decode($combined_order->shipping_address)->email;
                    $address = json_decode($combined_order->shipping_address)->address;
                    $city = json_decode($combined_order->shipping_address)->city;

                    return PayhereUtility::create_checkout_form($combined_order_id, $amount, $first_name, $last_name, $phone, $email, $address, $city);
                } elseif ($request->payment_option == 'cash_on_delivery') {
                    flash(translate("Your order has been placed successfully"))->success();
                    return redirect()->route('order_confirmed');
                } elseif ($request->payment_option == 'wallet') {
                    $user = Auth::user();
                    $combined_order = CombinedOrder::findOrFail($request->session()->get('combined_order_id'));
                    if ($user->balance >= $combined_order->grand_total) {
                        $user->balance -= $combined_order->grand_total;
                        $user->save();
                        return $this->checkout_done($request->session()->get('combined_order_id'), null);
                    }
                } else {
                    $combined_order = CombinedOrder::findOrFail($request->session()->get('combined_order_id'));
                    foreach ($combined_order->orders as $order) {
                        $order->manual_payment = 1;
                        $order->save();
                    }
                    flash(__('front.Your order has been placed successfully. Please submit payment information from purchase history'))->success();
                    return redirect()->route('order_confirmed');
                }
            }
        } else {
            flash(__('front.Select Payment Option.'))->warning();
            return back();
        }
    }

    //redirects to this method after a successfull checkout
    public function checkout_done($combined_order_id, $payment)
    {
        $combined_order = CombinedOrder::findOrFail($combined_order_id);
        $payment = json_decode($payment);
        foreach ($combined_order->orders as $key => $order) {
            $order = Order::findOrFail($order->id);
            $order->payment_status = 'paid';
            $order->payment_details = $payment->status;
            $order->payment_type = $payment->method;
            $order->save();

            calculateCommissionAffilationClubPoint($order);
        }

        Session::put('combined_order_id', $combined_order_id);
        return redirect()->route('order_confirmed');
    }

    public function get_shipping_info(Request $request)
    {
        if(Auth::check()) {
            $carts = Cart::where('user_id', Auth::user()->id)->get();
        }else{
            $temp_user_id = $request->session()->get('temp_user_id');
            $carts = ($temp_user_id != null) ? Cart::where('temp_user_id', $temp_user_id)->get() : [] ;

        }//        if (Session::has('cart') && count(Session::get('cart')) > 0) {
        if ($carts && count($carts) > 0) {
            $categories = Category::all();
            return view('frontend.shipping_info', compact('categories', 'carts'));
        }
        flash(__('front.Your cart is empty'))->success();
        return back();
    }

    public function store_shipping_info(Request $request)
    {
        // dd($request->address_id);

        if ($request->address_id == null) {
            flash(translate("Please add shipping address"))->warning();
            return back();
        }

        $carts = Cart::where('user_id', Auth::user()->id)->get();

        foreach ($carts as $key => $cartItem) {
            $cartItem->address_id = $request->address_id;
            $cartItem->save();
        }

        return view($this->design.'.delivery_info', compact('carts'));
    }


    public function store_delivery_info(Request $request)
    {
        $carts = Cart::where('user_id', Auth::user()->id)
                ->get();

        if($carts->isEmpty()) {
            flash(__('front.Your cart is empty'))->warning();
            return redirect()->route('home');
        }

        $shipping_info = Address::where('id', $carts[0]['address_id'])->first();
        $total = 0;
        $tax = 0;
        $shipping = 0;
        $subtotal = 0;

        if ($carts && count($carts) > 0) {
            foreach ($carts as $key => $cartItem) {
                $product = \App\Models\Product::find($cartItem['product_id']);
                $tax += $cartItem['tax'] * $cartItem['quantity'];
                $subtotal += $cartItem['price'] * $cartItem['quantity'];

                if ($request['shipping_type_' . $product->user_id] == 'pickup_point') {
                    $cartItem['shipping_type'] = 'pickup_point';
                    $cartItem['pickup_point'] = $request['pickup_point_id_' . $product->user_id];
                } else {
                    $cartItem['shipping_type'] = 'home_delivery';
                }
                $cartItem['shipping_cost'] = 0;
                if ($cartItem['shipping_type'] == 'home_delivery') {
                    $cartItem['shipping_cost'] = getShippingCost($carts, $key);
                }

                if(isset($cartItem['shipping_cost']) && is_array(json_decode($cartItem['shipping_cost'], true))) {

                    foreach(json_decode($cartItem['shipping_cost'], true) as $shipping_region => $val) {
                        if($shipping_info['city'] == $shipping_region) {
                            $cartItem['shipping_cost'] = (double)($val);
                            break;
                        } else {
                            $cartItem['shipping_cost'] = 0;
                        }
                    }
                } else {
                    if (!$cartItem['shipping_cost'] ||
                            $cartItem['shipping_cost'] == null ||
                            $cartItem['shipping_cost'] == 'null') {

                        $cartItem['shipping_cost'] = 0;
                    }
                }

                $shipping += $cartItem['shipping_cost'];
                $cartItem->save();

            }
            $total = $subtotal + $tax + $shipping;
            return view($this->design.'.payment_select', compact('carts', 'shipping_info', 'total'));

        } else {
            flash(__('front.Your Cart was empty'))->warning();
            return redirect()->route('home');
        }
    }

    public function apply_coupon_code(Request $request)
    {
//        if(null == null){
//            $coupon = Coupon::where('code', $request->code)->first();
//            dd(CouponUsage::where('user_id', Auth::user()->id)->where('coupon_id', $coupon->id)->first());
//        }
//
//        else
//            dd('a8a');


        $coupon = Coupon::where('code', $request->code)->first();
        $response_message = array();

        if ($coupon != null) {
//            $dataSecond = strtotime(date('m-d-Y'));
//                dd(strtotime("08/03/2022").'==='.strtotime("08/03/2022")."|".strtotime('08-03-2022')."|".strtotime('08/03/2022')."|".$dataSecond ." |||||| $coupon->start_date || ||$coupon->end_date ");
            $dataSecond = strtotime(date('d-m-Y'));
            if (($dataSecond >= $coupon->start_date) && ($dataSecond <= $coupon->end_date)) {

                $cU = CouponUsage::where('user_id', Auth::user()->id)->where('coupon_id', $coupon->id)->first();
                if ( !($cU) ) {
                        $coupon_details = json_decode($coupon->details);

                        $carts = Cart::where('user_id', Auth::user()->id)
                                        ->where('owner_id', $coupon->user_id)
                                        ->get();

                        if ($coupon->type == 'cart_base') {
                                $subtotal = 0;
                                $tax = 0;
                                $shipping = 0;
                                foreach ($carts as $key => $cartItem) {
                                    $subtotal += $cartItem['price'] * $cartItem['quantity'];
                                    $tax += $cartItem['tax'] * $cartItem['quantity'];
                                    $shipping += $cartItem['shipping_cost'];
                                }
                                $sum = $subtotal + $tax + $shipping;

                                if ($sum >= $coupon_details->min_buy) {
                                        if ($coupon->discount_type == 'percent') {
                                            $coupon_discount = ($sum * $coupon->discount) / 100;
                                            if ($coupon_discount > $coupon_details->max_discount) {
                                                $coupon_discount = $coupon_details->max_discount;
                                            }
                                            }elseif ($coupon->discount_type == 'amount') {
                                                $coupon_discount = $coupon->discount;
                                            }

                                }
                        }elseif ($coupon->type == 'product_base') {
                            $coupon_discount = 0;
                            foreach ($carts as $key => $cartItem) {
                                foreach ($coupon_details as $key => $coupon_detail) {
                                    if ($coupon_detail->product_id == $cartItem['product_id']) {
                                        if ($coupon->discount_type == 'percent') {
                                            $coupon_discount += ($cartItem['price'] * $coupon->discount / 100) * $cartItem['quantity'];
                                        } elseif ($coupon->discount_type == 'amount') {
                                            $coupon_discount += $coupon->discount * $cartItem['quantity'];
                                        }
                                    }
                                }
                            }
                        }




                        Cart::where('user_id', Auth::user()->id)
                                ->where('owner_id', $coupon->user_id)
                                ->update(
                                        [
                                            'discount' => $coupon_discount / count($carts),
                                            'coupon_code' => $request->code,
                                            'coupon_applied' => 1
                                        ]
                        );

                        $response_message['response'] = 'success';
                        $response_message['message'] = __('front.Coupon has been applied');
                }else{
                    $response_message['response'] = 'warning';
                    $response_message['message'] = __('front.You already used this coupon!');
                }
            }else {

                $response_message['response'] = 'warning';
                $response_message['message'] = __('front.Coupon expired!');
            }
        } else {
            $response_message['response'] = 'danger';
            $response_message['message'] = __('front.Invalid coupon!');
        }

        $carts = Cart::where('user_id', Auth::user()->id)
                ->get();
        $shipping_info = Address::where('id', $carts[0]['address_id'])->first();

        $returnHTML = view($this->design.'.partials.cart_summary', compact('coupon', 'carts', 'shipping_info'))->render();
        return response()->json(array('response_message' => $response_message, 'html'=>$returnHTML));
    }

    public function remove_coupon_code(Request $request)
    {
        Cart::where('user_id', Auth::user()->id)
                ->update(
                        [
                            'discount' => 0.00,
                            'coupon_code' => '',
                            'coupon_applied' => 0
                        ]
        );

        $coupon = Coupon::where('code', $request->code)->first();
        $carts = Cart::where('user_id', Auth::user()->id)
                ->get();

        $shipping_info = Address::where('id', $carts[0]['address_id'])->first();

        return view('frontend.partials.cart_summary', compact('coupon', 'carts', 'shipping_info'));
    }

    public function apply_club_point(Request $request) {
        if (addon_is_activated('club_point')){

            $point = $request->point;

            if(Auth::user()->point_balance >= $point) {
                $request->session()->put('club_point', $point);
                flash(__('front.Point has been redeemed'))->success();
            }
            else {
                flash(__('front.Invalid point!'))->warning();
            }
        }
        return back();
    }

    public function remove_club_point(Request $request) {
        $request->session()->forget('club_point');
        return back();
    }

    public function order_confirmed()
    {
        $combined_order = CombinedOrder::findOrFail(Session::get('combined_order_id'));

        Cart::where('user_id', $combined_order->user_id)
                ->delete();

        //Session::forget('club_point');
        //Session::forget('combined_order_id');

        foreach($combined_order->orders as $order){
            NotificationUtility::sendOrderPlacedNotification($order);
        }

        return view($this->design.'.order_confirmed', compact('combined_order'));
    }
}
