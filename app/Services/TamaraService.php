<?php
namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class TamaraService
{
    protected $baseUrl;
    protected $secretKey;
    protected $publicKey;
    protected $countryCode;
    protected $currency;
    protected $client;
    protected $tamaraMode;

    public function __construct()
    {
        $this->tamaraMode = config('service.tamara.mode');
        $this->baseUrl = ($this->tamaraMode == 'live') ? config('service.tamara.live_api_url') : config('service.tamara.test_api_url');
        $this->secretKey = config('service.tamara.secret_key');
        $this->publicKey = config('service.tamara.public_key');
        // $this->currency     = config('tamara.currency');
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function createCheckoutSession(array $orderData)
    {
        try {
            $response = $this->client->post("/checkout", ['json' => $orderData]);
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