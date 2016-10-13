<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Barryvdh\DomPDF\Facade as PDF;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent\EloquentPlatformRepository;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent\EloquentTransactionRepository;
use Webaccess\ProjectSquarePayment\Requests\Platforms\UpdatePlatformUsersCountRequest;
use Webaccess\ProjectSquarePayment\Responses\Platforms\UpdatePlatformUsersCountResponse;

class MyAccountController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->platformRepository = new EloquentPlatformRepository();
        $this->transactionRepository = new EloquentTransactionRepository();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $platform = $this->platformRepository->getByID($this->getCurrentPlatformID());

        return view('projectsquare-payment::my_account.index', [
            'user' => $user,
            'users_count' => $platform->getUsersCount(),
            'balance' => $platform->getAccountBalance(),
            'daily_cost' => app()->make('GetPlatformUsageAmountInteractor')->getDailyCost($this->getCurrentPlatformID()),
            'monthly_cost' => app()->make('GetPlatformUsageAmountInteractor')->getMonthlyCost($this->getCurrentPlatformID()),
            'invoices' => $this->getInvoices($this->getCurrentPlatformID())
        ]);
    }

    public function udpate_users_count(Request $request)
    {
        try {
            $response = app()->make('UpdatePlatformUsersCountInteractor')->execute(new UpdatePlatformUsersCountRequest([
                'platformID' => $this->getCurrentPlatformID(),
                'usersCount' => $request->users_count,
            ]));

            return response()->json([
                'success' => $response->success,
                'error' => ($response->errorCode) ? $this->getErrorMessage($response->errorCode) : null,
                'daily_cost' => app()->make('GetPlatformUsageAmountInteractor')->getDailyCost($this->getCurrentPlatformID()),
                'monthly_cost' => app()->make('GetPlatformUsageAmountInteractor')->getMonthlyCost($this->getCurrentPlatformID()),
            ], 200);
        } catch (Exception $e) {
            app()->make('LaravelLoggerService')->error($e->getMessage(), $request->all(), $e->getFile(), $e->getLine());

            return response()->json([
                'success' => false,
                'error' => trans('projectsquare-payment::my_account.update_platform_users_count_generic_error'),
            ], 500);
        }
    }

    public function invoice(Request $request)
    {
        $transaction = $this->getInvoice($request->invoice_identifier);

        $pdf = PDF::loadView('projectsquare-payment::my_account.invoice', [
            'invoice' => $transaction
        ]);

        return (isset($request->download) && $request->download == 1) ? $pdf->download('facture-projectsquare-' . $request->invoice_identifier . '.pdf') : $pdf->stream();
    }

    private function getCurrentPlatformID()
    {
        $user = auth()->user();

        return ($user) ? $user->platform_id : false;
    }

    /**
     * @param $errorCode
     * @return string
     */
    private function getErrorMessage($errorCode)
    {
        $errorMessages = [
            UpdatePlatformUsersCountResponse::PLATFORM_NOT_FOUND_ERROR_CODE => trans('projectsquare-payment::my_account.update_platform_users_count_generic_error'),
            UpdatePlatformUsersCountResponse::ACTUAL_USERS_COUNT_TOO_BIG_ERROR => trans('projectsquare-payment::my_account.platform_users_count_actual_users_count_too_big_error'),
            UpdatePlatformUsersCountResponse::INVALID_USERS_COUNT => trans('projectsquare-payment::my_account.platform_users_count_invalid_users_count_error'),
        ];

        return (isset($errorMessages[$errorCode])) ? $errorMessages[$errorCode] :  trans('projectsquare-payment::my_account.update_platform_users_count_generic_error');
    }

    private function getInvoices($platformID)
    {
        $invoices = $this->transactionRepository->getByPlatformID($platformID);
        foreach ($invoices as $invoice) {
            $invoice->creation_date = \DateTime::createFromFormat('Y-m-d H:i:s', $invoice->created_at)->format('d/m/Y H:i:s');
        }

        return $invoices;
    }

    private function getInvoice($transactionIdentifier)
    {
        $invoice = $this->transactionRepository->getByIdentifier($transactionIdentifier);
        $invoice->creation_date = \DateTime::createFromFormat('Y-m-d H:i:s', $invoice->getCreationDate())->format('d/m/Y H:i:s');

        return $invoice;
    }
}