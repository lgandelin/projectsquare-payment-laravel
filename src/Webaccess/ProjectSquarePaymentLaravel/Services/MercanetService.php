<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Services;

class MercanetService
{
    public static function generateFormFields($amount, $transactionReference)
    {
        $merchantID = env('MERCANET_MERCHANT_ID');
        $keyVersion = env('MERCANET_KEY_VERSION');
        $parameters = [
            'amount' => $amount * 100,
            'currencyCode' => 978,
            'merchantId' => $merchantID,
            'normalReturnUrl' => env('MERCANET_RETURN_URL'),
            'transactionReference' => $transactionReference,
            'keyVersion' => $keyVersion
        ];

        $data = self::getDataFieldFromParameters($parameters);
        $seal = self::getSealFromData($data);

        return array($data, $seal);
    }

    /**
     * @param $data
     * @param $seal
     * @return bool
     */
    public static function checkSignature($data, $seal)
    {
        return self::getSealFromData($data) === $seal;
    }

    /**
     * @param $parameters
     * @return string
     */
    private static function getDataFieldFromParameters($parameters) {
        $data = '';
        foreach ($parameters as $key => $value) {
            $data .= $key . '=' . $value . '|';
        }

        return rtrim($data, '|');
    }

    /**
     * @param $data
     * @return string
     */
    private static function getSealFromData($data)
    {
        return hash('sha256', $data. env('MERCANET_SECRET_KEY'));
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function extractTransactionIdentifierFromData($data)
    {
        if (preg_match('/transactionReference=([a-zA-Z0-9\_]*)/', $data, $matches)) {
            return isset($matches[1]) ? $matches[1] : false;
        }

        return false;
    }

    /**
     * @param $data
     * @return mixed
     */
    public static function extractAmountFromData($data)
    {
        if (preg_match('/amount=([0-9\.]*)/', $data, $matches)) {
            return isset($matches[1]) ? floatval($matches[1]) / 100 : false;
        }

        return false;
    }
}