<?php
namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class AramexService  
{

    private $apiUrl;
    private $credentials;
    private $client;

    public function __construct()
    {
        $this->apiUrl = config('aramex.api_url');
        $this->credentials = [
            'ClientInfo' => [
                'AccountCountryCode' => config('aramex.country_code'),
                'AccountEntity' => config('aramex.entity'),
                'AccountNumber' => config('aramex.account_number'),
                'AccountPin' => config('aramex.account_pin'),
                'UserName' => config('aramex.username'),
                'Password' => config('aramex.password'),
                'Version' => 'v1',
            ],
        ];
        $this->client = new Client([
            'base_uri' => $this->apiUrl,
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function createShipment(array $shipmentData)
    {
        $payload = array_merge($this->credentials, $shipmentData);

        $response = $this->client->post('/shipping/CreateShipments', [
            'json' => $payload,
        ]);

        return json_decode($response->getBody(), true);
    }

//     public function createShipments(array $shipments)
//     {
//         $payload = array_merge($this->credentials, [
//             'Shipments' => $shipments,
//         ]);
//         $response = Http::post("{$this->apiUrl}/shipping/CreateShipments", $payload);

//         return $response->json();
//     }
}