<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Order;
use App\Models\Payment;
use Session;
use PDF;
use Config;

class InvoiceController extends Controller
{
    //download invoice
    public function invoice_download($id)
    {
//
//        if(Session::has('currency_code')){
//            $currency_code = Session::get('currency_code');
//        }
//        else{
//            $currency_code = Currency::findOrFail(get_setting('system_default_currency'))->code;
//        }
//        $language_code = Session::get('locale', Config::get('app.locale'));
//
//        if(Language::where('code', $language_code)->first()->rtl == 1){
//            $direction = 'rtl';
//            $text_align = 'right';
//            $not_text_align = 'left';
//        }else{
//            $direction = 'ltr';
//            $text_align = 'left';
//            $not_text_align = 'right';
//        }
//
//
//
//        if($currency_code == 'BDT' || $language_code == 'bd'){
//            // bengali font
//            $font_family = "'Hind Siliguri','sans-serif'";
//        }elseif($currency_code == 'KHR' || $language_code == 'kh'){
//            // khmer font
//            $font_family = "'Hanuman','sans-serif'";
//        }elseif($currency_code == 'AMD'){
//            // Armenia font
//            $font_family = "'arnamu','sans-serif'";
//        }elseif($currency_code == 'ILS'){
//            // Israeli font
//            $font_family = "'Varela Round','sans-serif'";
//        }elseif($currency_code == 'AED' || $currency_code == 'EGP' || $language_code == 'sa' || $currency_code == 'IQD' || $language_code == 'ir' || $language_code == 'om' || $currency_code == 'ROM'){
//            // middle east/arabic font
//            $font_family = "'XBRiyaz','sans-serif'";
//        }else{
//            // general for all
//            $font_family = "'Roboto','sans-serif'";
//        }
        $font_family = "'Roboto','sans-serif'";
        $direction = 'ltr';
        $text_align = 'left';
        $not_text_align = 'right';

        $order = Order::findOrFail($id);
        $payment = Payment::where('order_id', $order->id)->first();

        return PDF::loadView('backend.invoices.invoice',[
            'order' => $order,
            'payment' => $payment,
            'font_family' => $font_family,
            'direction' => $direction,
            'text_align' => $text_align,
            'not_text_align' => $not_text_align
        ], [], [])->download('order-'.$order->code.'.pdf');
    }
}
