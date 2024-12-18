<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Website\CheckoutController;
use App\Models\Customer;
use App\Models\Order;
use App\Models\CombinedOrder;
use App\Models\ProductTax;
use App\Models\Upload;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\User;
use App\Services\TabbyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
class TabbyController extends Controller
{

    protected $tabbyService;
    protected $data = []; // array to save your payment data
    protected $marchent_code;

    public function __construct() {

        $this->marchent_code = env('MARCHENT_CODE');
        $this->tabbyService = new TabbyService();
    }

    public function getdata(int $combined_order_id, float $amount)
    {
        $cuurency = \App\Models\Currency::findOrFail(get_setting('system_default_currency'))->code;
        $order = Order::where('combined_order_id', $combined_order_id)->first();
        $customer = User::findOrFail($order->user_id);
        $orderDetail = OrderDetail::where('order_id', $order->id)->get();
        $products = $orderDetail->map(function ($item) {
            $photoIds = explode(',', $item->product->photos);
            $urls = Upload::whereIn('id', $photoIds)->pluck('file_name')->toArray();
            $product['images'] = array_map(function ($fileName) {
                return asset("/$fileName");
            }, $urls);
            return [
                'title' => $item->product->name,
                'description' => $item->product->description,
                'quantity' => $item->quantity,
                'unit_price' => number_format($item->product->unit_price, 2, '.', ''),
                'discount_amount' => number_format($item->product->discount, 2, '.', ''),
                'discount_type' => $item->product->discount_type,
                'category' => $item->product->category->name,
                // 'reference_id' => strval($item->product_id),
                'image_url' => $product['images'][0],
            ];
        });

        $items = $products->map(function ($item) {
            return [
                "title" => $item['title'],
                "description" => 'description product',
                "quantity" => $item['quantity'],
                "unit_price" => $item['unit_price'],
                "discount_amount" => $item['discount_amount'],
                "category" => $item['category'],
                // "reference_id" => $item['reference_id'],
                "image_url" => $item['image_url'],
            ];
        })->toArray();
        $zip_code = json_decode($order['shipping_address'])->postal_code ? json_decode($order['shipping_address'])->postal_code : "11751";
        $productsIds = $products->pluck('reference_id')->toArray();
        $totalTaxes = ProductTax::whereIn('product_id', $productsIds)->sum('tax');

        $data = [
            "payment" => [
                "amount" => (string) number_format($amount, 2, '.', ''),
                "currency" => "SAR",
                "description" => "Sample order description",
                "buyer" => [
                    "phone" => $customer->phone,
                    "email" => "card.success@tabby.ai",//$customer->email,
                    "name" => $customer->name,
                    "dob" => "1990-01-01"
                ],
                "shipping_address" => [
                    "city" => json_decode($order['shipping_address'])->state,
                    "address" => json_decode($order['shipping_address'])->address,
                    "zip" => $zip_code
                ],
                "order" => [
                    "tax_amount" => (string) number_format($totalTaxes, 2, '.', ''),
                    "shipping_amount" => (string) number_format($orderDetail->pluck('shipping_cost')[0], 2, '.', ''),
                    "discount_amount" => "0.00",
                    "updated_at" => $order->updated_at->toIso8601String(),
                    "reference_id" => $order->code,
                    "items" => $items,
                ],
                "buyer_history" => [
                    "registered_since" => $customer->created_at->toIso8601String(),
                    "loyalty_level" => 0,
                    "wishlist_count" => 0,
                    "is_social_networks_connected" => true,
                    "is_phone_number_verified" => true,
                    "is_email_verified" => true
                ],
                "order_history" => [
                    [
                        "purchased_at" => $order->created_at->toIso8601String(),
                        "amount" => number_format($amount, 2, '.', ''),
                        "payment_method" => "card",
                        "status" => "new",
                        "buyer" => [
                            "phone" => $customer->phone,
                            "email" => "card.success@tabby.ai",//$customer->email,
                            "name" => $customer->name,
                            "dob" => "1990-01-01"
                        ],
                        "shipping_address" => [
                            "city" => json_decode($order['shipping_address'])->state,
                            "address" => json_decode($order['shipping_address'])->address,
                            "zip" => $zip_code
                        ],
                    ]
                ],
                "meta" => (object) [
                    "order_id" => $order->id,
                    "customer" => $customer->id
                ],
                "attachment" => (object) [
                    "body" => "{\"flight_reservation_details\": {\"pnr\": \"TR9088999\",\"itinerary\": [...],\"insurance\": [...],\"passengers\": [...],\"affiliate_name\": \"some affiliate\"}}",
                    "content_type" => "application/vnd.tabby.v1+json"
                ]
            ],
            "lang" => "ar",
            "merchant_code" => $this->marchent_code,
            "merchant_urls" => [
                "success" => url('/tabby/success'),
                "cancel" => url('/tabby/cancel'),
                "failure" => url('/tabby/failure')
            ],
            "token" => null
        ];


        return $data;
    }

    public function initiateCheckoutWithRealData()
    {
        try {
            $combined_order = CombinedOrder::findOrFail(Session::get('combined_order_id'));
            $amount = round($combined_order->grand_total );
            $data = $this->getdata($combined_order->id, $amount);
            $response = $this->tabbyService->createCheckoutSession($data);
            // dd($response);
            if (isset($response['id']) && $response['id'] != '') {
                $redirect_url = $response['configuration']['available_products']['installments'][0]['web_url'];
                $payment = $response['payment'];
                Session::put('payment',$payment);
                return redirect($redirect_url);                 // Redirect user to Tabby checkout
            } else {
                flash(translate('Payment is cancelled'))->error();
                return redirect()->route('tabby.cancel');
            }
        } catch (\Exception $e) {
            \Log::error('tabby '.$e->getMessage());
            return redirect()->home();
        }

    }

    public function initiateCheckout()
    {
        try {

            // $combined_order = CombinedOrder::findOrFail(Session::get('combined_order_id'));
            // $amount = round($combined_order->grand_total );
            // $data = $this->getdata($combined_order->id, $amount);
            // Call Tabby API for checkout session
        // $data = json_encode($data);
        // dd($data);


        $data = [
    "payment" => [
        "amount" => "100.00",
        "currency" => "SAR",
        "description" => "Sample order description",
        "buyer" => [
            "phone" => "966500000001",
            "email" => "card.success@tabby.ai",
            "name" => "John Doe",
            "dob" => "1990-01-01"
        ],
        "shipping_address" => [
            "city" => "Riyadh",
            "address" => "1234 Street Name",
            "zip" => "12345"
        ],
        "order" => [
            "tax_amount" => "0.00",
            "shipping_amount" => "0.00",
            "discount_amount" => "0.00",
            "updated_at" => now()->toIso8601String(),
            "reference_id" => "order_12345",
            "items" => [
                [
                    "title" => "Sample Product",
                    "description" => "Sample product description",
                    "quantity" => 1,
                    "unit_price" => "100.00",
                    "discount_amount" => "0.00",
                    "reference_id" => "prod_123",
                    "image_url" => "http://example.com/image.jpg",
                    "product_url" => "http://example.com/product",
                    "gender" => "Unisex",
                    "category" => "Electronics",
                    "color" => "Black",
                    "product_material" => "Plastic",
                    "size_type" => "Medium",
                    "size" => "M",
                    "brand" => "Brand Name",
                    "is_refundable" => true
                ]
            ]
        ],
    ],
    "lang" => "ar",
    "merchant_code" =>  $this->marchent_code ,
    "merchant_urls" => [
        "success" => url('/tabby/success'),
        "cancel" => url('/tabby/cancel'),
        "failure" => url('/tabby/failure')
    ],
    "token" => null
];

// dd($data);
            $response = $this->tabbyService->createCheckoutSession($data);
// dd($response);
            if (isset($response['id']) && $response['id'] != '') {
                $redirect_url = $response['configuration']['available_products']['installments'][0]['web_url'];
                // dd($redirect_url);
                return redirect($redirect_url);                 // Redirect user to Tabby checkout
            } else {
                                dd('ggggggggggg');

                flash(translate('Payment is cancelled'))->error();
                return redirect()->route('tabby.cancel');
            }
        } catch (\Exception $e) {
            \Log::error('tabby '.$e->getMessage());
            dd($e->getMessage());
            return redirect()->home();
        }
    }

    // Retrieve  payment methods
    // public function retrievePayment(string $paymentId)
    // {
    //     try {
    //         dd($paymentId);
    //         $response = $this->tabbyService->retrievePayment($paymentId);
    //         dd($response);
    //         if ($response->status() == 200) {
    //             return $response;
    //             // return response()->json([
    //             //     'code' => $response->status(),
    //             //     'data' => $response->object()
    //             // ], $response->status());
    //         } else {
    //             return response()->json([
    //                 'code' => $response->status(),
    //                 'error' => $response->json()
    //             ], $response->status());
    //         }
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'code' => $e->getCode(),
    //             'error' => $e->getMessage()
    //         ], $e->getCode());
    //     }
    // }

    public function success(Request $request)
    {
        try {
            $payment = Session::get('payment');
            // to check if operation done in test mode or live mode
            // if (isset($payment['is_test']) && $payment['is_test']) {
            //         flash(translate('Payment is work with test version'))->error();
            //         return redirect()->route('home');
            // } else {
                $payment_status = [
                    "status" => "Success",
                    "method" => "tabby",
                ];
                Payment::create([
                    'payment_id' => $payment['id'],
                    'order_id' => session()->get('combined_order_id'),
                    'payment_method' => 'tabby',
                    'amount' => $payment['amount'],
                    'payment_details' => json_encode($payment),
                ]);
                $checkoutController = new CheckoutController;
                return $checkoutController->checkout_done(session()->get('combined_order_id'), json_encode($payment_status));
            // }
        } catch (\Exception $e) {
            flash(translate('Payment failed'))->error();
            return redirect()->route('home');
        }
    }

    public function cancel(Request $request)
    {
        flash(translate('Payment is cancelled'))->error();
        return redirect()->route('home');
    }

    // retrieve checkout session
    // public function getCheckoutSession($id)
    // {
    //     try {
    //         // Call Tabby API for checkout session
    //         $response = $this->tabbyService->getCheckoutSession($id);
    //         if ($response->successful()) {
    //             return response()->json([
    //                 'code' => $response->status(),
    //                 'data' => $response->object()
    //             ], 200);
    //         } else {
    //             return response()->json([
    //                 'code' => $response->status(),
    //                 'error' => $response->json()
    //             ], $response->status());
    //         }
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'code' => $e->getCode(),
    //             'error' => $e->getMessage()
    //         ], $e->getCode());
    //     }
    // }

    // public function capturePayment(Request $request, string $paymentId)
    // {
    //     try {
    //         $request->validate([
    //             'amount' => 'required|numeric',
    //         ]);
    //         $amount = $request->input('amount');

    //         $captureResponse = $this->tabbyService->capturePayment($paymentId, $amount);
    //         if ($captureResponse) {
    //             return response()->json([
    //                 'code' => $captureResponse->status(),
    //                 'data' => $captureResponse->object()
    //             ], $captureResponse->status());
    //         }
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'code' => $e->getCode(),
    //             'error' => $e->getMessage()
    //         ], $e->getCode());
    //     }
    // }

    // // Update Payment
    // public function updatePayment(Request $request, string $paymentId)
    // {
    //     try {
    //         $request->validate([
    //             'reference_id' => 'required',
    //         ]);
    //         $reference_id = $request->input('reference_id');

    //         $updateResponse = $this->tabbyService->updatePayment($paymentId, $reference_id);
    //         if ($updateResponse) {
    //             return response()->json([
    //                 'code' => $updateResponse->status(),
    //                 'data' => $updateResponse
    //             ], $updateResponse->status());
    //         }
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'code' => $e->getCode(),
    //             'error' => $e->getMessage()
    //         ], $e->getCode());
    //     }
    // }

    // // close Payment
    // public function closePayment(string $paymentId)
    // {
    //     try {
    //         $response = $this->tabbyService->closePayment($paymentId);
    //         if ($response) {
    //             return response()->json([
    //                 'code' => $response->status(),
    //                 'data' => $response->object()
    //             ], $response->status());
    //         } else {
    //             return response()->json([
    //                 'code' => $response->status(),
    //                 'error' => $response->json()
    //             ], $response->status());
    //         }
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'code' => $e->getCode(),
    //             'error' => $e->getMessage()
    //         ], $e->getCode());
    //     }
    // }

    // // get all payments
    // public function getAllPayments()
    // {
    //     try {
    //         $response = $this->tabbyService->getAllPayments();
    //         if ($response) {
    //             return response()->json([
    //                 'code' => $response->status(),
    //                 'data' => $response->object()
    //             ], $response->status());
    //         } else {
    //             return response()->json([
    //                 'code' => $response->status(),
    //                 'error' => $response->json()
    //             ], $response->status());
    //         }
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'code' => $e->getCode(),
    //             'error' => $e->getMessage()
    //         ]);
    //     }
    // }

    // // refund Payment
    // public function refundPayment(string $paymentId, Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'amount' => 'required|numeric',
    //         ]);
    //         $amount = $request->input('amount');
    //         $response = $this->tabbyService->refundPayment($paymentId, $amount);
    //         if ($response) {
    //             return response()->json([
    //                 'code' => $response->status(),
    //                 'data' => $response->object()
    //             ], $response->status());
    //         } else {
    //             return response()->json([
    //                 'code' => $response->status(),
    //                 'error' => $response->json()
    //             ], $response->status());
    //         }
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'code' => $e->getCode(),
    //             'error' => $e->getMessage()
    //         ], $e->getCode());
    //     }
    // }

}
