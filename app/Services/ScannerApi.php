<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class ScannerApi
{

    protected $api_key, $base_url, $client;

    public function __construct(Client $client)
    {
        $this->api_key = config('app.cloudmersive_api_key');
        $this->base_url = config('app.cloudmersive_base_url');
        $this->client = $client;
    }

    public function postScanUrl($url)
    {
        try {
            $response = $this->client->post($this->base_url.'/virus/scan/website', [
                'headers' => [
                    'Apikey' => $this->api_key,
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'Url' => $url,
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $result = json_decode($response->getBody()->getContents());

            return response()->json(['data' => $result]);
        }
    }
}
