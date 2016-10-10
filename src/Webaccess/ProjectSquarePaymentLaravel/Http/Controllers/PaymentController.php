<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Webaccess\ProjectSquarePaymentLaravel\Models\Transaction;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent\EloquentTransactionRepository;
use Webaccess\ProjectSquarePaymentLaravel\Services\MercanetService;
use Webaccess\ProjectSquarePaymentLaravel\Utils\Logger;
use Webaccess\ProjectSquarePayment\Requests\Platforms\FundPlatformAccountRequest;
use Webaccess\ProjectSquarePayment\Responses\Platforms\FundPlatformAccountResponse;

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

        Logger::info('New result from bank : ', $parameters);

        if (!$transaction = $this->getTransactionByIdentifier($transactionIdentifier)) {
            Logger::error('Transaction not found', 'PaymentController', '43', [
                'transactionID' => $transactionIdentifier,
                'amount' => $amount,
                'platformID' => $transaction->platform_id,
            ]);
        } elseif (!MercanetService::checkSignature($request->Data, $request->Seal)) {
            Logger::error('Signature check failed', 'PaymentController', '52', [
                'transactionID' => $transactionIdentifier,
                'amount' => $amount,
                'platformID' => $transaction->platform_id,
            ]);
        } elseif ($transaction->amount != $amount) {
            Logger::error('Amount verification failed', 'PaymentController', '58', [
                'transactionID' => $transactionIdentifier,
                'amount' => $amount,
                'platformID' => $transaction->platform_id,
            ]);
        } elseif ($transaction->status == Transaction::TRANSACTION_STATUS_IN_PROGRESS) {
            try {
                $response = app()->make('FundPlatformAccountInteractor')->execute(new FundPlatformAccountRequest([
                    'platformID' => $transaction->platform_id,
                    'amount' => $amount,
                ]));

                if (!$response->success) {
                    Logger::error('FundPlatformAccountInteractor error', 'PaymentController', 70, [
                        'transactionID' => $transactionIdentifier,
                        'amount' => $amount,
                        'platformID' => $transaction->platform_id,
                        'errorCode' => $response->errorCode,
                    ]);
                } else {
                    $transaction = $this->getTransactionByIdentifier($transactionIdentifier);
                    $transaction->payment_mean = $parameters['paymentMeanType'] . ' - ' . $parameters['paymentMeanBrand'];
                    $transaction->status = Transaction::TRANSACTION_STATUS_VALIDATED;
                    $transaction->response_code = $parameters['responseCode'];
                    $transaction->save();

                    Logger::info('Nouvelle transaction effectuée avec succès : ', [
                        'transactionIdentifier' => $transactionIdentifier,
                        'platformID' => $transaction->platform_id,
                        'amount' => $transaction->amount,
                    ]);
                }

            } catch (Exception $e) {
                Logger::error($e->getMessage(), $e->getFile(), $e->getLine(), $request->all());
            }
        }

        return redirect()->route('payment_result', ['transactionID' => $transactionIdentifier]);
    }

    /**
     * @param $transactionIdentifier
     * @return mixed
     */
    public function payment_result($transactionIdentifier)
    {
        $transaction = $this->getTransactionByIdentifier($transactionIdentifier);

        return view('projectsquare-payment::my_account.payment_result', [
            'transaction' => $transaction
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