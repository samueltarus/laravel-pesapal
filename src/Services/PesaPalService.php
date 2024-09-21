<?php

namespace samueltarus\LaravelPesaPal\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class PesaPalService
{
    protected $consumerKey;
    protected $consumerSecret;
    protected $endpoint;
    protected $client;

    public function __construct()
    {
        $this->consumerKey = config('pesapal.consumer_key');
        $this->consumerSecret = config('pesapal.consumer_secret');
        $this->endpoint = config('pesapal.endpoint');
        $this->client = new Client(['base_uri' => $this->endpoint]);
    }

    public function getAuthToken()
    {
        try {
            $response = $this->client->post('/api/Auth/RequestToken', [
                'json' => [
                    'consumer_key' => $this->consumerKey,
                    'consumer_secret' => $this->consumerSecret
                ]
            ]);

            $result = json_decode($response->getBody(), true);
            return $result['token'];
        } catch (GuzzleException $e) {
            // Handle the exception (log it, return null, or throw a custom exception)
            return null;
        }
    }

    public function submitOrder(array $orderDetails)
    {
        $token = $this->getAuthToken();
        if (!$token) {
            return ['error' => 'Failed to obtain auth token'];
        }

        try {
            $response = $this->client->post('/api/Transactions/SubmitOrderRequest', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                ],
                'json' => $orderDetails
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            // Handle the exception
            return ['error' => $e->getMessage()];
        }
    }

    public function getTransactionStatus($orderTrackingId)
    {
        $token = $this->getAuthToken();
        if (!$token) {
            return ['error' => 'Failed to obtain auth token'];
        }

        try {
            $response = $this->client->get("/api/Transactions/GetTransactionStatus?orderTrackingId={$orderTrackingId}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            // Handle the exception
            return ['error' => $e->getMessage()];
        }
    }
}