<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Webaccess\ProjectSquarePayment\Requests\Payment\InitTransactionRequest;
use Webaccess\ProjectSquarePayment\Requests\Payment\HandleBankCallRequest;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent\EloquentTransactionRepository;
use Webaccess\ProjectSquarePaymentLaravel\Utils\Logger;

class PaymentController extends Controller
{
    public $transactionRepository;

    public function __construct()
    {
        $this->transactionRepository = new EloquentTransactionRepository();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function payment_form(Request $request)
    {
        $response = app()->make('InitTransactionInteractor')->execute(new InitTransactionRequest([
            'platformID' => $this->getCurrentPlatformID(),
            'amount' => $request->amount
        ]));

        return response()->json([
            'success' => true,
            'data' => $response->data,
            'seal' => $response->seal,
        ], 200);
    }

    /**
     * @param Request $request
     */
    public function payment_handler(Request $request)
    {
        Logger::info('New call from the bank : ', $request->Data);

        $success = false;
        try {
            $response = app()->make('HandleBankCallInteractor')->execute(new HandleBankCallRequest([
                'data' => $request->Data,
                'seal' => $request->Seal,
            ]));

            if (!$response->success) {
                Logger::error('HandleBankCallInteractor call return an error (' . $response->errorCode . ')', 'PaymentController', null, [
                    'transactionIdentifier' => $response->transactionIdentifier,
                    'parameters' => $response->Data,
                    'amount' => $response->amount,
                    'errorCode' => $response->errorCode,
                ]);
            } else {
                $success = true;
                Logger::info('New transaction successfully processed ! : (' . $response->transactionIdentifier . ')', $response);
            }

        } catch (Exception $e) {
            Logger::error($e->getMessage(), $e->getFile(), $e->getLine(), $request->all());
        }

        return redirect()->route('payment_result', [
            'success' => ($success === true) ? '1' : '0',
            'transaction_identifier' => $response->transactionIdentifier
        ]);
    }

    /**
     * @param $transactionIdentifier
     * @return mixed
     */
    public function payment_result($success, $transactionIdentifier)
    {
        $transaction = $this->transactionRepository->getByIdentifier($transactionIdentifier);

        return view('projectsquare-payment::my_account.payment_result', [
            'success' => $success,
            'transaction' => $transaction,
        ]);
    }

    /**
     * @return mixed
     */
    private function getCurrentPlatformID()
    {
        $user = auth()->user();

        return ($user) ? $user->platform_id : false;
    }
}