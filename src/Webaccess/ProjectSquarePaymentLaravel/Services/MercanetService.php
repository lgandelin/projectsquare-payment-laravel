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
     * @return array
     */
    public static function extractParametersFromData($data)
    {
        $parameters = [];
        $pairs = explode('|', $data);

        foreach ($pairs as $i) {
            //split into name and value
            list($name,$value) = explode('=', $i, 2);

            //if name already exists
            if( isset($parameters[$name]) ) {
                //stick multiple values into an array
                if( is_array($parameters[$name]) ) {
                    $parameters[$name][] = $value;
                }
                else {
                    $parameters[$name] = array($parameters[$name], $value);
                }
            }
            else {
                $parameters[$name] = $value;
            }
        }

        return $parameters;
    }
}