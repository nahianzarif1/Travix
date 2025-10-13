<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SSLCommerzService
{
    private $storeId;
    private $storePassword;
    private $apiUrl;
    private $successUrl;
    private $failUrl;
    private $cancelUrl;

    public function __construct()
    {
        $this->storeId = config('sslcommerz.store_id', 'testbox');
        $this->storePassword = config('sslcommerz.store_password', 'qwerty');
        $this->apiUrl = config('sslcommerz.api_url', 'https://sandbox.sslcommerz.com/gwprocess/v4/api.php');
        $this->successUrl = url(config('sslcommerz.success_url', '/payment/success'));
        $this->failUrl = url(config('sslcommerz.fail_url', '/payment/fail'));
        $this->cancelUrl = url(config('sslcommerz.cancel_url', '/payment/cancel'));
    }

    public function initiatePayment(Payment $payment, $customerInfo)
    {
        $transactionId = 'TXN' . time() . Str::random(6);
        
        $data = [
            'store_id' => $this->storeId,
            'store_passwd' => $this->storePassword,
            'total_amount' => $payment->amount,
            'currency' => $payment->currency,
            'tran_id' => $transactionId,
            'success_url' => $this->successUrl,
            'fail_url' => $this->failUrl,
            'cancel_url' => $this->cancelUrl,
            'emi_option' => 0,
            'cus_name' => $customerInfo['name'],
            'cus_email' => $customerInfo['email'],
            'cus_add1' => $customerInfo['address'] ?? 'Dhaka',
            'cus_city' => $customerInfo['city'] ?? 'Dhaka',
            'cus_state' => $customerInfo['state'] ?? 'Dhaka',
            'cus_postcode' => $customerInfo['postcode'] ?? '1000',
            'cus_country' => $customerInfo['country'] ?? 'Bangladesh',
            'cus_phone' => $customerInfo['phone'],
            'cus_fax' => $customerInfo['phone'],
            'shipping_method' => 'NO',
            'product_name' => 'Travel Booking',
            'product_category' => 'Travel',
            'product_profile' => 'general',
            'value_a' => $payment->id,
            // bKash specific parameters
            'multi_card_name' => 'bkash',
            'allowed_bin' => 'bkash',
        ];

        $response = Http::asForm()->post($this->apiUrl, $data);

        if ($response->successful()) {
            $responseData = $response->json();
            
            if (isset($responseData['status']) && $responseData['status'] === 'SUCCESS') {
                $payment->update([
                    'transaction_id' => $transactionId,
                    'sslcommerz_sessionkey' => $responseData['sessionkey'] ?? null,
                    'sslcommerz_tran_id' => $responseData['tran_id'] ?? null,
                    'sslcommerz_response' => $responseData,
                ]);

                return [
                    'success' => true,
                    'redirect_url' => $responseData['GatewayPageURL'] ?? null,
                    'sessionkey' => $responseData['sessionkey'] ?? null,
                ];
            }
        }

        return [
            'success' => false,
            'message' => 'Payment initiation failed',
        ];
    }

    public function validatePayment($tranId, $amount, $currency)
    {
        $data = [
            'store_id' => $this->storeId,
            'store_passwd' => $this->storePassword,
            'tran_id' => $tranId,
            'val_id' => $tranId,
            'amount' => $amount,
            'currency' => $currency,
        ];

        $response = Http::asForm()->post($this->apiUrl, $data);
        
        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}
