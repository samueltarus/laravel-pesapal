<?php

namespace samueltarus\LaravelPesaPal\Http\Controllers;

use Illuminate\Http\Request;
use samueltarus\LaravelPesaPal\Facades\PesaPal;

class PesaPalController
{
    public function processPayment(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'description' => 'required|string',
            'callback_url' => 'required|url',
        ]);

        $orderDetails = [
            'id' => uniqid('order_'),
            'currency' => $validatedData['currency'],
            'amount' => $validatedData['amount'],
            'description' => $validatedData['description'],
            'callback_url' => $validatedData['callback_url'],
        ];

        $result = PesaPal::submitOrder($orderDetails);

        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], 400);
        }

        return response()->json($result);
    }

    public function checkStatus(Request $request)
    {
        $orderTrackingId = $request->input('order_tracking_id');
        
        if (!$orderTrackingId) {
            return response()->json(['error' => 'Order tracking ID is required'], 400);
        }

        $result = PesaPal::getTransactionStatus($orderTrackingId);

        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], 400);
        }

        return response()->json($result);
    }
}