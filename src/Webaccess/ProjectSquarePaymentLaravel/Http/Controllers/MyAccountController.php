<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade as PDF;
use stdClass;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent\EloquentAdministratorRepository;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent\EloquentPlatformRepository;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent\EloquentTransactionRepository;
use Webaccess\ProjectSquarePayment\Requests\Administrators\UpdateAdministratorRequest;
use Webaccess\ProjectSquarePayment\Responses\Administrators\UpdateAdministratorResponse;
use Webaccess\ProjectSquarePayment\Requests\Platforms\UpdatePlatformUsersCountRequest;
use Webaccess\ProjectSquarePayment\Responses\Platforms\UpdatePlatformUsersCountResponse;

class MyAccountController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->platformRepository = new EloquentPlatformRepository();
        $this->transactionRepository = new EloquentTransactionRepository();
        $this->administratorRepository = new EloquentAdministratorRepository();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $platform = $this->platformRepository->getByID($this->getCurrentPlatformID());
        $endTrialDate = $platform->getCreationDate()->addMonths(1);

        return view('projectsquare-payment::my_account.index', [
            'user' => $user,
            'users_count' => $platform->getUsersCount(),
            'balance' => $platform->getAccountBalance(),
            'daily_cost' => app()->make('GetPlatformUsageAmountInteractor')->getDailyCost($this->getCurrentPlatformID()),
            'monthly_cost' => app()->make('GetPlatformUsageAmountInteractor')->getMonthlyCost($this->getCurrentPlatformID()),
            'trial_version' => ($endTrialDate > new Carbon()) ? true : false,
            'date_end_trial_version' => $endTrialDate,
            'invoices' => $this->getInvoices($this->getCurrentPlatformID()),
            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
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

    public function update_administrator(Request $request)
    {
        try {
            $response = app()->make('UpdateAdministratorInteractor')->execute(new UpdateAdministratorRequest([
                'administratorID' => auth()->user()->id,
                'lastName' => $request->administrator_last_name,
                'firstName' => $request->administrator_first_name,
                'email' => $request->administrator_email,
                'password' => ($request->administrator_password) ? Hash::make($request->administrator_password) : null,
                'city' => $request->administrator_city,
                'billingAddress' => $request->administrator_billing_address,
                'zipcode' => $request->administrator_zipcode,
            ]));

            if ($response->success)
                $request->session()->flash('confirmation', trans('projectsquare-payment::my_account.update_administrator_update_success'));
            else
                $request->session()->flash('error', $this->getErrorMessage($response->errorCode));

            return redirect()->route('my_account');
        } catch (Exception $e) {
            app()->make('LaravelLoggerService')->error($e->getMessage(), $request->all(), $e->getFile(), $e->getLine());

            return redirect()->route('my_account');
        }
    }

    public function invoice(Request $request)
    {
        $transaction = $this->getInvoice($request->invoice_identifier);

        /*$pdf = PDF::loadView('projectsquare-payment::my_account.invoice', [
            'invoice' => $transaction
        ]);

        return (isset($request->download) && $request->download == 1) ? $pdf->download('facture-' . $request->invoice_identifier . '.pdf') : $pdf->stream();*/

        return view('projectsquare-payment::my_account.invoice', [
            'invoice' => $transaction
        ]);
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

            UpdateAdministratorResponse::ADMINISTRATOR_NOT_FOUND_ERROR => trans('projectsquare-payment::my_account.administrator_generic_error'),
            UpdateAdministratorResponse::ADMINISTRATOR_EMAIL_REQUIRED => trans('projectsquare-payment::my_account.administrator_email_required_error'),
            UpdateAdministratorResponse::ADMINISTRATOR_LAST_NAME_REQUIRED => trans('projectsquare-payment::my_account.administrator_last_name_required_error'),
            UpdateAdministratorResponse::ADMINISTRATOR_FIRST_NAME_REQUIRED => trans('projectsquare-payment::my_account.administrator_first_name_error'),
            UpdateAdministratorResponse::ADMINISTRATOR_CITY_REQUIRED => trans('projectsquare-payment::my_account.administrator_city_error'),
            UpdateAdministratorResponse::ADMINISTRATOR_BILLING_ADDRESS_REQUIRED => trans('projectsquare-payment::my_account.administrator_billing_address_error'),
            UpdateAdministratorResponse::ADMINISTRATOR_ZIPCODE_REQUIRED => trans('projectsquare-payment::my_account.administrator_zipcode_error'),
            UpdateAdministratorResponse::REPOSITORY_CREATION_FAILED => trans('projectsquare-payment::my_account.administrator_generic_error'),
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
        $transaction = $this->transactionRepository->getByIdentifier($transactionIdentifier);
        $transaction->creation_date = \DateTime::createFromFormat('Y-m-d H:i:s', $transaction->getCreationDate())->format('d/m/Y H:i:s');

        $administrator = $this->administratorRepository->getByPlatformID($transaction->getPlatformID());

        $platform = $this->platformRepository->getByID($transaction->getPlatformID());

        $invoice = new StdClass();
        $invoice->transaction = $transaction;
        $invoice->administrator = $administrator;
        $invoice->platform = $platform;

        return $invoice;
    }
}