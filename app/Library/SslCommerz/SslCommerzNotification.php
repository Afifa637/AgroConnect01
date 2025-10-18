<?php

namespace App\Library\SslCommerz;

use Illuminate\Support\Facades\Http;

class SslCommerzNotification
{
    public function makePayment($post_data, $type = 'checkout', $format = 'json')
    {
        $store_id = config('sslcommerz.store_id');
        $store_passwd = config('sslcommerz.store_password');
        $api_domain = config('sslcommerz.api_domain');

        $url = $api_domain . '/gwprocess/v4/api.php';
        $post_data['store_id'] = $store_id;
        $post_data['store_passwd'] = $store_passwd;

        // Call SSLCommerz API
        $response = Http::asForm()->post($url, $post_data);

        if ($response->failed()) {
            return "Failed to connect with SSLCOMMERZ API";
        }

        $sslcz = $response->json();
        if (isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL'] != "") {
            return redirect($sslcz['GatewayPageURL']);
        }
        return "JSON Data parsing error!";
    }

    public function orderValidate($tran_id, $amount, $currency, $post_data)
    {
        $store_id = config('sslcommerz.store_id');
        $store_passwd = config('sslcommerz.store_password');
        $api_domain = config('sslcommerz.api_domain');

        $val_id = urlencode($post_data['val_id']);
        $url = "$api_domain/validator/api/validationserverAPI.php?val_id=$val_id&store_id=$store_id&store_passwd=$store_passwd&format=json";

        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();

            // Verify amount & currency
            if (
                $data['status'] == 'VALID' &&
                $data['currency_type'] == $currency &&
                $data['amount'] == $amount
            ) {
                return TRUE;
            }
        }

        return FALSE;
    }
}
