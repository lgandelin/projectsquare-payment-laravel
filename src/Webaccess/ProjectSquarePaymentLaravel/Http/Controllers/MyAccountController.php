<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent\EloquentPlatformRepository;
use Webaccess\ProjectSquarePayment\Requests\Administrators\UpdateAdministratorRequest;
use Webaccess\ProjectSquarePayment\Responses\Administrators\UpdateAdministratorResponse;
use Webaccess\ProjectSquarePayment\Responses\Platforms\UpdatePlatformUsersCountResponse;

class MyAccountController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->platformRepository = new EloquentPlatformRepository();
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
            'subscription' => $user->subscription('user'),
            'users_count' => $platform->getUsersCount(),
            'monthly_cost' => app()->make('GetPlatformUsageAmountInteractor')->getMonthlyCost($this->getCurrentPlatformID()),
            'invoices' => ($user->subscription('user')) ? $user->invoices() : [],
            'error' => ($request->session()->has('error')) ? $request->session()->get('error') : null,
            'confirmation' => ($request->session()->has('confirmation')) ? $request->session()->get('confirmation') : null,
        ]);
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
}