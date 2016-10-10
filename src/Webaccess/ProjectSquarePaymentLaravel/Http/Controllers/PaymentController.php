<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Webaccess\ProjectSquarePaymentLaravel\Services\MercanetService;
use Webaccess\ProjectSquarePaymentLaravel\Utils\Logger;

class PaymentController extends Controller
{
    public function payment_form(Request $request)
    {
        //@TODO : Initier nouvelle transaction
        $transactionIdentifier = uniqid();

        list($data, $seal) = MercanetService::generateFormFields($request->amount, $transactionIdentifier);

        return response()->json([
            'success' => true,
            'data' => $data,
            'seal' => $seal,
        ], 200);
    }

    public function payment_handler(Request $request)
    {
        $transactionIdentifier = MercanetService::extractTransactionIdentifierFromData($request->Data);
        $amount = MercanetService::extractAmountFromData($request->Data);

        if (!MercanetService::checkSignature($request->Data, $request->Seal)) {
            Logger::error('Signature check failed', 'PaymentController', '31', [
                'transactionId' => $transactionIdentifier,
                'amount' => $amount
            ]);
        } elseif ($this->checkTransactionAmount($transactionIdentifier, $amount)) {
            Logger::error('Amount verification failed', 'PaymentController', '41', [
                'transactionId' => $transactionIdentifier,
                'amount' => $amount
            ]);
        } else {

        }
    }

    /**
     * @param $transactionIdentifier
     * @param $amount
     * @return bool
     */
    private function checkTransactionAmount($transactionIdentifier, $amount)
    {
        if ($transaction = $this->getTransactionByIdentifier($transactionIdentifier)) {
            return $transaction->amount != $amount;
        }

        return false;
    }

    /**
     * @param $transactionIdentifier
     * @return bool
     */
    private function getTransactionByIdentifier($transactionIdentifier)
    {
        return true;
    }
}