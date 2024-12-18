<?php

namespace App\Http\Controllers;
use App\Services\AramexService;
use App\Models\Address;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AramexController extends Controller
{
    private $aramexService;

    public function __construct(AramexService $aramexService)
    {
        $this->aramexService = $aramexService;
    }

    public function getData(int $user_id)
    {
        try {
            $carts = Cart::where('user_id', $user_id)->get();
            if ($carts->isEmpty()) {
                flash(__('front.Your cart is empty'))->warning();
                return redirect()->route('home');
            }

            $quantityOfItems = 0;
            $allWeight = 0;
            $totalPrice = 0;
            $shipping_info = Address::where('id', $carts[0]['address_id'])->first();
            // dd($shipping_info);
            if ($carts && count($carts) > 0) {
                foreach ($carts as $cartItem) {
                    $quantityOfItems += $cartItem->quantity;
                    $allWeight += $cartItem->quantity * explode(' ', $cartItem->product->unit)[0];
                    $totalPrice += $cartItem->quantity * $cartItem->price;

                }
            } else {
                flash(__('front.Your Cart was empty'))->warning();
                return redirect()->route('home');
            }

            $shipmentData = [
                'Shipments' => [
                    [
                        'Reference1' => 'Shpt-001', // Shipment reference
                        'Shipper' => [
                            'Reference1' => 'Ref-111111',
                            'PartyAddress' => [
                                'Line1' => env('FOOT_ADD'),
                                'City' => env('FOOT_LOCA'),
                                'CountryCode' => env('COUNTRY_CODE'),
                            ],
                            'Contact' => [
                                'PersonName' => env('FOOT_NAME'),
                                'CompanyName' => env('FOOT_NAME'),
                                'CellPhone' => env('HEAD_PHONE'),
                                'PhoneNumber1' => env('HEAD_PHONE'),
                                'EmailAddress' => env('HEAD_EMAIL'),
                            ],
                        ],
                        'Consignee' => [
                            'Reference1' => 'Ref-222222',
                            'PartyAddress' => [
                                'Line1' => $shipping_info->address,
                                'City' => $shipping_info->state->name,
                                'CountryCode' => $shipping_info->country->code,
                            ],
                            'Contact' => [
                                'PersonName' => $shipping_info->user->name,
                                'CompanyName' => 'customer company name',
                                'CellPhone' => $shipping_info->phone,
                                'PhoneNumber1' => $shipping_info->phone,
                                'EmailAddress' => $shipping_info->user->email,
                            ],
                        ],
                        'ShippingDateTime' => time() + 50000,
                        'Details' => [
                            'PaymentType' => 'P', // P: Prepaid, C: Collect
                            'ProductGroup' => 'EXP', // EXP: Express
                            'ProductType' => 'PDX', // PDX: Parcel Express
                            'NumberOfPieces' => $quantityOfItems,
                            'DescriptionOfGoods' => 'Documents',
                            'GoodsOriginCountry' => env('COUNTRY_CODE'),
                            'CashOnDeliveryAmount' => [
                                'Value' => 0,
                                'CurrencyCode' => env('COUNTRY_CURRENCY'),
                            ],
                            'ActualWeight' => [
                                'Value' => $allWeight,
                                'Unit' => 'KG',
                            ],
                        ],
                    ],
                ],
            ];
            return $shipmentData;
        } catch (\Exception $e) {
            flash(__('front.Your cart is empty'))->warning();
            return redirect()->route('home');
        }

    }
    
    public function createShipment(Request $request)
    {
        // try {
            // $user_id = $request->input('user_id');
            $shipmentData = $this->getData(351);
            $response = $this->aramexService->createShipment($shipmentData);
            // dd($response);

            // if (isset($response['HasErrors']) && $response['HasErrors']) {
            //     return response()->json(['error' => $response['Notifications']], 400);
            // }
            // return response()->json([
            //     'success' => true,
            //     'deliveryFees' => 50, // Example delivery fee
            // ]);
        // } catch (\Exception $e) {
        //     \Log::error('Error occurred: ' . $e->getMessage());
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'An error occurred.'
        //     ], 500);
        // }

    }
}
