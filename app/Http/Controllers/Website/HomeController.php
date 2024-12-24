<?php

namespace App\Http\Controllers\Website;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Mail\SecondEmailVerifyMailManager;
use App\Models\Ads;
use App\Models\AffiliateConfig;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\User;
use Auth;
use Cookie;
use Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Mail;
use function abort;
use Illuminate\Support\Str;
use function auth;
use function back;
use function flash;
use function view;
use App\Models\FlashDeal;
use App\Models\PaymentMethod;
use App\Models\PickupPoint;
use App\Models\ShippngCompany;
use App\Models\Slider;
use App\Models\SubCategory;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private  $design;
    public function __construct()
    {

       $this->design = "frontend";
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
//    public function index()
//    {
//        return view('home');
//    }


    //ads depand on lang
    public function ads()
    {
        $ads = Ads::where('status', Status::ACTIVE)
            ->where('featured', '1')->get();
        return $ads;

    }

    //sliders depand on lang
    public function sliders()
    {
        $sliders = Slider::where('published', '1')->limit(3)->get();
        return $sliders;
    }

    //subCategories depand on lang
    public function subCategories(Request $request)
    {
        $categoryId = $request->category_id;
        $subCategories = SubCategory::where('category_id', $categoryId)
            ->where('featured', 1)->get();
        return $subCategories;
    }
    
    //get shipping company
    public function getShippingCompany()
    {
        $shipping = ShippngCompany::where('status', Status::ACTIVE)
                                    ->where('featured', 1)
                                    ->get();
        return $shipping;
    }

    //get payment method
    public function getPaymentMethod()
    {
        $payment = PaymentMethod::where('status', Status::ACTIVE)->get();
        return $payment;
    }



    public function check(Request $request)
    {
        if($request->session()->has('lang')){
            
        }
    }
    public function index(){



        $brands = Brand::limit(4)->get();
        $flash = last_flash();
        $cats =Category::with('subCategories')->limit(3)->get(); // edit by mohamed

        $news           =   Product::where('featured',1)->limit(4)->get();
        $bests          =   Product::where('best', 1)->limit(4)->get();
        $hots           =   Product::where('todays_deal', 1)->limit(4)->get();
        $productLevel   =   Product::where('product_level','>', 0)
                                    ->orderBy('product_level', 'asc')
                                    ->orderBy('created_at', 'asc')
                                    ->limit(4)->get();

        $blogs          =   Blog::orderBy('created_at', 'desc')->limit(3)->get();

        $ads     =   $this->ads();
        $sliders =   $this->sliders();
        $paymentMethods =   $this->getPaymentMethod();
        $shipping       =   $this->getShippingCompany();
        return view($this->design.'.index')
            ->with('cats',$cats)
            ->with('flash',$flash)
            ->with('news',$news)
            ->with('bests',$bests)
            ->with('hots',$hots)
            ->with('productLevel',$productLevel)
            ->with('blogs',$blogs)
            ->with('brands',$brands)
            ->with('ads',$ads)
            ->with('sliders',$sliders)
            ->with('paymentMethods',$paymentMethods)
            ->with('shipping',$shipping);

    }

    public function home(){
        $brands = Brand::limit(6)->get();
    }


    public function new()
    {
        $brands = Brand::limit(6)->get();
        $flash = last_flash();
        $cats =Category::with('subCategories')->get(); // edit by mohamed

        $news           =   Product::where('featured',1)->limit(5)->get();
        $bests          =   Product::where('best', 1)->limit(5)->get();
        $hots           =   Product::where('todays_deal', 1)->limit(5)->get();
        $productLevel   =   Product::where('product_level','>', 0)
                                    ->orderBy('product_level', 'asc')
                                    ->orderBy('created_at', 'asc')
                                    ->limit(5)->get();
        $blogs          =   Blog::orderBy('created_at', 'desc')->limit(3)->get();
        $ads            =   $this->ads();
        $sliders        =   $this->sliders();
        $paymentMethods =   $this->getPaymentMethod();
        $shipping       =   $this->getShippingCompany();
        return view($this->design.'.index')
            ->with('cats',$cats)
            ->with('flash',$flash)
            ->with('news',$news)
            ->with('bests',$bests)
            ->with('hots',$hots)
            ->with('productLevel',$productLevel)
            ->with('blogs',$blogs)
            ->with('brands',$brands)
            ->with('sliders',$sliders)
            ->with('ads',$ads)
            ->with('paymentMethods',$paymentMethods)
            ->with('shipping',$shipping);

    }


    public function user()
    {

        if(Auth::user()->user_type == 'seller'){
            return view($this->design.'.user.seller.dashboard');
        }
        elseif(Auth::user()->user_type == 'customer'){

            return view($this->design.'.user.customer.dashboard');
        }
        elseif(Auth::user()->user_type == 'delivery_boy'){
            return view('delivery_boys.frontend.dashboard');
        }
        else {
            abort(404);
        }
    }


    public function dashboard()
    {

        if(Auth::user()->user_type == 'seller'){

            return view($this->design.'.user.seller.dashboard');
        }
        elseif(Auth::user()->user_type == 'customer'){

            return view($this->design.'.user.customer.dashboard');
        }
        elseif(Auth::user()->user_type == 'delivery_boy'){
            return view('delivery_boys.frontend.dashboard');
        }
        else {
            abort(404);
        }
    }

    public function about(){

        return view($this->design.'.about');
    }
    public function shop(){
        return view($this->design.'.shop');
    }
    public function blog(){
        return view($this->design.'.blog');
    }
    public function contact(){
        return view($this->design.'.contact');
    }

    public function cart(){
        return view($this->design.'.cart');
    }

    public function single(){
        return view($this->design.'.single');
    }

    public function checkout(){
        return view($this->design.'.checkout');
    }

    public function error(){
        return view($this->design.'.error');
    }
    public function myAccount(){
        return view($this->design.'.my-account');
    }
    public function loginV(){
        return view('auth.admin_login');
    }

    public function weOffer(){
        return view($this->design.'.we-offer');
    }


    public function login(Request $request)
    {

        $user = null;
        if($request->get('phone') != null){
            $user = User::whereIn('user_type', ['customer', 'seller'])->where('phone', "+{$request['country_code']}{$request['phone']}")->first();
        }
        elseif($request->get('email') != null){
            $user = User::whereIn('user_type', ['customer', 'seller'])->where('email', $request->email)->first();
        }

        if($user != null){
            if(Hash::check($request->password, $user->password)){
                if($request->has('remember')){
                    Auth::login($user, true);
                }
                else{
                    Auth::login($user, false);
                }
            }
            else {
                flash(translate('Invalid email or password!'))->warning();
            }
        }
        else{
            flash(translate('Invalid email or password!'))->warning();
        }
        return back();
    }

    public function adminLogin(Request $request)
    {
        $user = null;

        if ($request->get('email') != null) {
            $user = User::where('user_type', 'admin')->where('email', $request->email)->first();
        }

        if ($user != null) {
            // Try logging in with the given email and password
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // Check if the authenticated user is either 'admin' or 'staff'
                if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff') {
                    // You can instantiate the repository if needed here
                    // CoreComponentRepository::instantiateShopRepository();

                    // Redirect to the admin dashboard
                    return redirect()->route('admin.dashboard');
                } else {
                    // If the user is not admin or staff, log them out and show an error message
                    Auth::logout();
                    flash(translate('Access Denied!'))->warning();
                    return back();
                }
            } else {
                // If authentication fails
                flash(translate('Invalid email or password!'))->warning();
                return back();
            }
        } else {
            flash(translate('Invalid email or password!'))->warning();
            return back();
        }
    }




    public function profile(Request $request)
    {
        if(Auth::user()->user_type == 'delivery_boy'){
            return view('delivery_boys.frontend.profile');
        }
        else{
            return view($this->design.'.user.profile');
        }
    }

    public function userProfileUpdate(Request $request)
    {
        if(env('DEMO_MODE') == 'On'){
            flash(translate('Sorry! the action is not permitted in demo '))->error();
            return back();
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->phone = $request->phone;

        if($request->new_password != null && ($request->new_password == $request->confirm_password)){
            $user->password = Hash::make($request->new_password);
        }

        $user->avatar_original = $request->photo;

        $seller = $user->seller;

        if($seller){
            $seller->cash_on_delivery_status = $request->cash_on_delivery_status;
            $seller->bank_payment_status = $request->bank_payment_status;
            $seller->bank_name = $request->bank_name;
            $seller->bank_acc_name = $request->bank_acc_name;
            $seller->bank_acc_no = $request->bank_acc_no;
            $seller->bank_routing_no = $request->bank_routing_no;

            $seller->save();
        }

        $user->save();

        flash(translate('Your Profile has been updated successfully!'))->success();
        return back();
    }


    public function variant_price(Request $request)
    {
        $product = Product::find($request->id);
        $str = '';
        $quantity = 0;
        $tax = 0;
        $max_limit = 0;

        if($request->has('color')){
            $str = $request['color'];
        }

        if(json_decode($product->choice_options) != null){
            foreach (json_decode($product->choice_options) as $key => $choice) {
                if($str != null){
                    $str .= '-'.str_replace(' ', '', $request['attribute_id_'.$choice->attribute_id]);
                }
                else{
                    $str .= str_replace(' ', '', $request['attribute_id_'.$choice->attribute_id]);
                }
            }
        }

        $product_stock = $product->stocks->where('variant', $str)->first();
        $price = $product_stock->price;

        if($product->wholesale_product){
            $wholesalePrice = $product_stock->wholesalePrices->where('min_qty', '<=', $request->quantity)->where('max_qty', '>=', $request->quantity)->first();
            if($wholesalePrice){
                $price = $wholesalePrice->price;
            }
        }

        $quantity = $product_stock->qty;
        $max_limit = $product_stock->qty;

        if($quantity >= 1 && $product->min_qty <= $quantity){
            $in_stock = 1;
        }else{
            $in_stock = 0;
        }

        //Product Stock Visibility
        if($product->stock_visibility_state == 'text') {
            if($quantity >= 1 && $product->min_qty < $quantity){
                $quantity = translate('In Stock');
            }else{
                $quantity = translate('Out Of Stock');
            }
        }

        //discount calculation
        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        }
        elseif (strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if($product->discount_type == 'percent'){
                $price -= ($price*$product->discount)/100;
            }
            elseif($product->discount_type == 'amount'){
                $price -= $product->discount;
            }
        }

        // taxes
        foreach ($product->taxes as $product_tax) {
            if($product_tax->tax_type == 'percent'){
                $tax += ($price * $product_tax->tax) / 100;
            }
            elseif($product_tax->tax_type == 'amount'){
                $tax += $product_tax->tax;
            }
        }

        $price += $tax;

        return array(
            'price' => single_price($price*$request->quantity),
            'quantity' => $quantity,
            'digital' => $product->digital,
            'variation' => $str,
            'max_limit' => $max_limit,
            'in_stock' => $in_stock
        );
    }

    public function show_custom_page($slug){
        $page = Page::where('slug', $slug)->first();

        if($page != null){
            return view($this->design.'.custom_page', compact('page'));
        }
        abort(404);
    }
    public function faqs(){

            return view($this->design.'.faqs');


    }


    public function get_pick_up_points(Request $request)
    {
        $pick_up_points = PickupPoint::all();
        return view($this->design.'.partials.pick_up_points', compact('pick_up_points'));
    }

    public function cart_login(Request $request)
    {
        $user = null;
        if($request->get('phone') != null){
            $user = User::whereIn('user_type', ['customer', 'seller'])->where('phone', "+{$request['country_code']}{$request['phone']}")->first();
        }
        elseif($request->get('email') != null){
            $user = User::whereIn('user_type', ['customer', 'seller'])->where('email', $request->email)->first();
        }

        if($user != null){
            if(Hash::check($request->password, $user->password)){
                if($request->has('remember')){
                    Auth::login($user, true);
                }
                else{
                    Auth::login($user, false);
                }
            }
            else {
                flash(translate('Invalid email or password!'))->warning();
            }
        }
        else{
            flash(translate('Invalid email or password!'))->warning();
        }
        return back();
    }


    public function product(Request $request, $slug)
    {
        $detailedProduct  = Product::with('reviews', 'brand', 'stocks', 'user', 'user.shop')->where('auction_product', 0)->where('slug', $slug)->where('approved', 1)->first();

        if($detailedProduct != null && $detailedProduct->published){
            if($request->has('product_referral_code') && addon_is_activated('affiliate_system')) {

                $affiliate_validation_time = AffiliateConfig::where('type', 'validation_time')->first();
                $cookie_minute = 30 * 24;
                if($affiliate_validation_time) {
                    $cookie_minute = $affiliate_validation_time->value * 60;
                }
                Cookie::queue('product_referral_code', $request->product_referral_code, $cookie_minute);
                Cookie::queue('referred_product_id', $detailedProduct->id, $cookie_minute);

                $referred_by_user = User::where('referral_code', $request->product_referral_code)->first();

                // $affiliateController = new AffiliateController;
                // $affiliateController->processAffiliateStats($referred_by_user->id, 1, 0, 0, 0);
            }
            if($detailedProduct->digital == 1){
                return view($this->design.'.digital_product_details', compact('detailedProduct'));
            }
            else {
                return view($this->design.'.product_details', compact('detailedProduct'));
            }
        }
        abort(404);
    }




    // Form request
    public function update_email(Request $request)
    {
        $email = $request->email;
        if(isUnique($email)) {
            $this->send_email_change_verification_mail($request, $email);
            flash(translate('A verification mail has been sent to the mail you provided us with.'))->success();
            return back();
        }

        flash(translate('Email already exists!'))->warning();
        return back();
    }

    public function send_email_change_verification_mail($request, $email)
    {
        $response['status'] = 0;
        $response['message'] = 'Unknown';

        $verification_code = Str::random(32);

        $array['subject'] = 'Email Verification';
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['content'] = 'Verify your account';
        $array['link'] = route('email_change.callback').'?new_email_verificiation_code='.$verification_code.'&email='.$email;
        $array['sender'] = Auth::user()->name;
        $array['details'] = "Email Second";

        $user = Auth::user();
        $user->new_email_verificiation_code = $verification_code;
        $user->save();

        try {
            Mail::to($email)->queue(new SecondEmailVerifyMailManager($array));

            $response['status'] = 1;
            $response['message'] = translate("Your verification mail has been Sent to your email.");

        } catch (\Exception $e) {
            // return $e->getMessage();
            $response['status'] = 0;
            $response['message'] = $e->getMessage();
        }

        return $response;
    }

    public function email_change_callback(Request $request){
        if($request->has('new_email_verificiation_code') && $request->has('email')) {
            $verification_code_of_url_param =  $request->input('new_email_verificiation_code');
            $user = User::where('new_email_verificiation_code', $verification_code_of_url_param)->first();

            if($user != null) {

                $user->email = $request->input('email');
                $user->new_email_verificiation_code = null;
                $user->save();

                Auth::login($user, true);

                flash(translate('Email Changed successfully'))->success();
                return redirect()->route('dashboard');
            }
        }

        flash(translate('Email was not verified. Please resend your mail!'))->error();
        return redirect()->route('dashboard');

    }

    // Ajax call
    public function new_verify(Request $request)
    {
        $email = $request->email;
        if(isUnique($email) == '0') {
            $response['status'] = 2;
            $response['message'] = 'Email already exists!';
            return json_encode($response);
        }

        $response = $this->send_email_change_verification_mail($request, $email);
        return json_encode($response);
    }


    public function reset_password_with_code(Request $request){
        if (($user = User::where('email', $request->phone)->where('verification_code', $request->code)->first()) != null) {
            if($request->password == $request->password_confirmation){
                $user->password = Hash::make($request->password);
                $user->email_verified_at = date('Y-m-d h:m:s');
                $user->save();
                event(new PasswordReset($user));
                Auth::login($user, true);

                if(Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff')
                {
                    return redirect()->route('admin.dashboard');
                }
                return redirect()->route('home');
            }
            else {
                flash("Password and confirm password didn't match")->warning();
                return back();
            }
        }
        else {
            flash("Verification code mismatch")->error();
            return back();
        }
    }


    public function flash_deal_details($slug)
    {
        $flash_deal = FlashDeal::where('slug', $slug)->first();
        if($flash_deal != null)
            return view($this->design.'.flash_deal.flash_deal_details', compact('flash_deal'));
        else {
            abort(404);
        }
    }
    public function all_flash_deals() {
        $today = strtotime(date('Y-m-d H:i:s'));

        $data['all_flash_deals'] = FlashDeal::where('status', 1)
            ->where('start_date', "<=", $today)
            ->where('end_date', ">", $today)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view($this->design.'.flash_deal.all_flash_deal_list', $data);
    }

}
