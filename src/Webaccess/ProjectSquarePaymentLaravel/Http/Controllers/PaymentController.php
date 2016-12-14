<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Webaccess\ProjectSquarePayment\Requests\Payment\InitTransactionRequest;
use Webaccess\ProjectSquarePayment\Requests\Payment\HandleBankCallRequest;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent\EloquentTransactionRepository;

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
        try {
            $response = app()->make('InitTransactionInteractor')->execute(new InitTransactionRequest([
                'platformID' => $this->getCurrentPlatformID(),
                'amount' => $request->amount
            ]));

            return response()->json([
                'success' => true,
                'data' => $response->data,
                'seal' => $response->seal,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => trans('projectsquare-payment::payment.generic_error'),
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function payment_handler(Request $request)
    {
        try {
            $response = app()->make('HandleBankCallInteractor')->execute(new HandleBankCallRequest([
                'data' => $request->Data,
                'seal' => $request->Seal,
            ]));
        } catch (Exception $e) {
            app()->make('LaravelLoggerService')->error($e->getMessage(), $request->all(), $e->getFile(), $e->getLine());
        }

        return redirect()->route('payment_result', [
            'transaction_identifier' => $response->transactionIdentifier
        ]);
    }

    /**
     * @param $transactionIdentifier
     * @return mixed
     */
    public function payment_result($transactionIdentifier)
    {
        $transaction = $this->transactionRepository->getByIdentifier($transactionIdentifier);

        return view('projectsquare-payment::payment.result', [
            'status' => $transaction->getStatus(),
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