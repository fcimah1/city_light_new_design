<?php

// namespace App\Services;

// use Illuminate\Support\Facades\Http;

// class TabbyService
// {
//     protected $apiUrl;
//     protected $publicKey;
//     protected $secretKey;
//     protected $merchantId;

//     public function __construct()
//     {
//         $this->apiUrl = config('services.tabby.api_url');
//         $this->publicKey = config('services.tabby.public_key');
//         $this->secretKey = config('services.tabby.secret_key');
//         $this->merchantId = env('MARCHENT_CODE');
//     }

//     public function createCheckoutSession($data)
//     {
//         $http = Http::withToken($this->secretKey)->baseUrl($this->apiUrl);
//         $response = $http->post('v2/checkout', $data);
//         return $response;
//     }
    
//     public function getCheckoutSession($id)
//     {
//         $http = Http::withToken($this->secretKey)->baseUrl($this->apiUrl);
//         $response = $http->get('v2/checkout/' . $id);
//         return $response;
//     }

//     public function capturePayment(string $paymentId, float $amount)
//     {
//         $http = Http::withToken($this->secretKey)->baseUrl($this->apiUrl);
//         $response = $http->post('v2/payments/' . $paymentId . '/captures', [
//             'amount' => $amount,
//         ]);

//         if ($response->ok()) {
//             dd($response->json());
//         }

//         return response()->json([
//             'code' => $response->status(),
//             'error' => $response->json(),
//         ],  $response->status());
//     }

//     public function retrievePayment(string $paymentId)
//     {
//         $http = Http::withToken($this->secretKey)->baseUrl($this->apiUrl);
//         $response = $http->get('/payments/' . $paymentId);
//         return $response;
//     }

//     public function getAllPayments()
//     {
//         $http = Http::withToken($this->secretKey)->baseUrl($this->apiUrl);
//         $response = $http->get('v2/payments');
//         return $response;
//     }

//     public function updatePayment(string $paymentId, array $data)
//     {
//         $http = Http::withToken($this->secretKey)->baseUrl($this->apiUrl);
//         $response = $http->put('v2/payments/' . $paymentId, $data);

//         return $response;
//     }
 
//     public function closePayment(string $paymentId)
//     {
//         $http = Http::withToken($this->secretKey)->baseUrl($this->apiUrl);
//         $response = $http->post('v2/payments/' . $paymentId . '/cancels');
//         return $response;
//     }
//     public function refundPayment(string $paymentId, float $amount)
//     {
//         $http = Http::withToken($this->secretKey)->baseUrl($this->apiUrl);
//         $response = $http->post('v2/payments/' . $paymentId . '/refunds', [
//             'amount' => $amount,
//         ]);

//         return $response;
//     }

//     public function registerWebhook($url,$isTest)
//     {
//         $http = Http::withToken($this->secretKey)->withHeaders([
//             'X-Merchant-code' => $this->merchantId,
//         ])->baseUrl($this->apiUrl);
//         $response = $http->post('v1/webhooks', [
//             'url' => $url,
//             'is_test' => $isTest,
//         ]);
//         return $response;
//     }

// }



namespace App\Services;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class TabbyService
{
    protected $client;
    protected $baseUrl;
    protected $publicKey;
    protected $secretKey;
    protected $merchantId;

    public function __construct()
    {
        

        $this->merchantId = env('MARCHENT_CODE');
        $this->baseUrl = config('services.tabby.api_url');
        $this->publicKey = config('services.tabby.public_key');
        $this->secretKey = config('services.tabby.secret_key');

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
                
            ],
        ]);
    }

    /**
     * Create a checkout session with Tabby
     *
     * @param array $data
     * @return array
     */
     
    public function createCheckoutSession(array $data)
    {
        try {
            $response = $this->client->post('v2/checkout', [
                'json' => $data,
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            // Handle errors
            if ($e->hasResponse()) {
                return [
                    'error' => true,
                    'message' => $e->getResponse()->getBody()->getContents()
                ];
            }

            return [
                'error' => true,
                'message' => 'An error occurred while creating the checkout session.'
            ];
        }
    }
}
