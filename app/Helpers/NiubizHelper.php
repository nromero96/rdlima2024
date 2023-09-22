<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config; // Importa la clase Config

class NiubizHelper
{
    public static function generateToken()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => config('niubiz.VISA_URL_SECURITY'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                'Authorization: ' . 'Basic ' . base64_encode(config('niubiz.VISA_USER') . ":" . config('niubiz.VISA_PWD'))
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public static function generateSession($amount, $token)
    {
        $session = array(
            'amount' => $amount,
            'antifraud' => array(
                'clientIp' => $_SERVER['REMOTE_ADDR'],
                'merchantDefineData' => array(
                    'MDD4' => "mail@domain.com",
                    'MDD33' => "DNI",
                    'MDD34' => '87654321'
                ),
            ),
            'channel' => 'web',
        );
        $json = json_encode($session);
        $response = json_decode(self::postRequest(config('niubiz.VISA_URL_SESSION'), $json, $token));
        return $response->sessionKey;
    }

    public static function generateAuthorization($amount, $purchaseNumber, $transactionToken, $token)
    {
        $data = array(
            'antifraud' => null,
            'captureType' => 'manual',
            'channel' => 'web',
            'countable' => true,
            'order' => array(
                'amount' => $amount,
                'currency' => 'PEN',
                'purchaseNumber' => $purchaseNumber,
                'tokenId' => $transactionToken
            ),
            'recurrence' => null,
            'sponsored' => null
        );
        $json = json_encode($data);
        $session = json_decode(self::postRequest(config('niubiz.VISA_URL_AUTHORIZATION'), $json, $token));
        return $session;
    }

    public static function postRequest($url, $postData, $token)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $token,
                'Content-Type: application/json'
            ),
            CURLOPT_POSTFIELDS => $postData
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public static function generatePurchaseNumber()
    {
        $archivo = storage_path('app/purchaseNumber.txt');
        $purchaseNumber = 222;
        $fp = fopen($archivo, "r");
        $purchaseNumber = fgets($fp, 100);
        fclose($fp);
        ++$purchaseNumber;
        $fp = fopen($archivo, "w+");
        fwrite($fp, $purchaseNumber, 100);
        fclose($fp);
        return $purchaseNumber;
    }
}
