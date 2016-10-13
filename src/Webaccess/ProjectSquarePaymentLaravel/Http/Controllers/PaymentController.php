<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Webaccess\ProjectSquarePayment\Requests\Payment\HandleBankCallRequest;
use Webaccess\ProjectSquarePayment\Responses\Payment\HandleBankCallResponse;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent\EloquentTransactionRepository;
use Webaccess\ProjectSquarePaymentLaravel\Services\MercanetService;
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
        $transactionIdentifier = $this->transactionRepository->initTransaction($this->getCurrentPlatformID(), $request->amount);

        list($data, $seal) = MercanetService::generateFormFields($request->amount, $transactionIdentifier);

        return response()->json([
            'success' => true,
            'data' => $data,
            'seal' => $seal,
        ], 200);
    }

    /**
     * @param Request $request
     */
    public function payment_handler(Request $request)
    {
        $parameters = MercanetService::extractParametersFromData($request->Data);
        $transactionIdentifier = $parameters['transactionReference'];
        $amount = floatval($parameters['amount']) / 100;

        Logger::info('New call from the bank : ', $parameters);

        $success = false;
        try {
            $response = app()->make('HandleBankCallInteractor')->execute(new HandleBankCallRequest([
                'transactionIdentifier' => $transactionIdentifier,
                'amount' => $amount,
                'data' => $request->Data,
                'seal' => $request->Seal,
                'parameters' => $parameters,
            ]));

            if (!$response->success) {
                Logger::error('HandleBankCallInteractor call return an error (' . $response->errorCode . ')', 'PaymentController', null, [
                    'transactionIdentifier' => $transactionIdentifier,
                    'parameters' => $parameters,
                    'amount' => $amount,
                    'errorCode' => $response->errorCode,
                ]);
            } else {
                $success = true;
                Logger::info('New transaction successfully processed ! : (' . $transactionIdentifier . ')', $response);
            }

        } catch (Exception $e) {
            Logger::error($e->getMessage(), $e->getFile(), $e->getLine(), $request->all());
        }

        return redirect()->route('payment_result', [
            'success' => ($success === true) ? '1' : '0',
            'transaction_identifier' => $transactionIdentifier
        ]);
    }

    /**
     * @param $transactionIdentifier
     * @return mixed
     */
    public function payment_result($success, $transactionIdentifier)
    {
        $transaction = $this->getTransactionByIdentifier($transactionIdentifier);

        return view('projectsquare-payment::my_account.payment_result', [
            'success' => $success,
            'transaction' => $transaction,
        ]);
    }

    /**
     * @param $transactionIdentifier
     * @return bool
     */
    private function getTransactionByIdentifier($transactionIdentifier)
    {
        return $this->transactionRepository->getByIdentifier($transactionIdentifier);
    }

    private function getCurrentPlatformID()
    {
        $user = auth()->user();

        return ($user) ? $user->platform_id : false;
    }
}