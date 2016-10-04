<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Webaccess\ProjectSquarePaymentLaravel\Repositories\EloquentPlatformRepository;
use Webaccess\ProjectSquarePaymentLaravel\Utils\Logger;
use Webaccess\ProjectSquarePayment\Requests\Platforms\FundPlatformAccountRequest;
use Webaccess\ProjectSquarePayment\Responses\Platforms\FundPlatformAccountResponse;
use Webaccess\ProjectSquarePayment\Requests\Platforms\UpdatePlatformUsersCountRequest;
use Webaccess\ProjectSquarePayment\Responses\Platforms\UpdatePlatformUsersCountResponse;

class MyAccountController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->platformRepository = new EloquentPlatformRepository();
    }

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
        ]);
    }

    public function udpate_users_count(Request $request)
    {
        $usersCount = $request->users_count;

        try {
            $response = app()->make('UpdatePlatformUsersCountInteractor')->execute(new UpdatePlatformUsersCountRequest([
                'platformID' => $this->getCurrentPlatformID(),
                'usersCount' => $usersCount,
                'actualUsersCount' => app()->make('PlatformAPIGateway')->getUsersCountFromRealPlatform($this->getCurrentPlatformID())
            ]));

            if ($response->success) {
                app()->make('PlatformAPIGateway')->updateUsersCountInRealPlatform($this->getCurrentPlatformID(), $usersCount);
            }

            return response()->json([
                'success' => $response->success,
                'error' => ($response->errorCode) ? $this->getErrorMessageUpdateUsersCount($response->errorCode) : null,
                'daily_cost' => app()->make('GetPlatformUsageAmountInteractor')->getDailyCost($this->getCurrentPlatformID()),
                'monthly_cost' => app()->make('GetPlatformUsageAmountInteractor')->getMonthlyCost($this->getCurrentPlatformID()),
            ], 200);
        } catch (Exception $e) {
            Logger::error($e->getMessage(), $e->getFile(), $e->getLine(), $request->all());

            return response()->json([
                'success' => false,
                'error' => trans('projectsquare-payment::my_account.update_platform_users_count_generic_error'),
            ], 500);
        }
    }

    public function fund_account(Request $request)
    {
        try {
            $response = app()->make('FundPlatformAccountInteractor')->execute(new FundPlatformAccountRequest([
                'platformID' => $this->getCurrentPlatformID(),
                'amount' => $request->amount,
            ]));

            return response()->json([
                'success' => $response->success,
                'error' => ($response->errorCode) ? $this->getErrorMessageFundAccount($response->errorCode) : null,
            ], 200);
        } catch (Exception $e) {
            Logger::error($e->getMessage(), $e->getFile(), $e->getLine(), $request->all());

            return response()->json([
                'success' => false,
                'error' => trans('projectsquare-payment::my_account.fund_platform_account_generic_error'),
            ], 500);
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
    private function getErrorMessageUpdateUsersCount($errorCode)
    {
        $errorMessages = [
            UpdatePlatformUsersCountResponse::PLATFORM_NOT_FOUND_ERROR_CODE => trans('projectsquare-payment::my_account.update_platform_users_count_generic_error'),
            UpdatePlatformUsersCountResponse::ACTUAL_USERS_COUNT_TOO_BIG_ERROR => trans('projectsquare-payment::my_account.platform_users_count_actual_users_count_too_big_error'),
            UpdatePlatformUsersCountResponse::INVALID_USERS_COUNT => trans('projectsquare-payment::my_account.platform_users_count_invalid_users_count_error'),
        ];

        return (isset($errorMessages[$errorCode])) ? $errorMessages[$errorCode] :  trans('projectsquare-payment::my_account.update_platform_users_count_generic_error');
    }

    /**
     * @param $errorCode
     * @return mixed
     */
    private function getErrorMessageFundAccount($errorCode)
    {
        $errorMessages = [
            FundPlatformAccountResponse::PLATFORM_NOT_FOUND_ERROR_CODE => trans('projectsquare-payment::my_account.fund_platform_account_generic_error'),
            FundPlatformAccountResponse::INVALID_AMOUNT_ERROR_CODE => trans('projectsquare-payment::my_account.fund_platform_account_invalid_amount_error'),
            FundPlatformAccountResponse::REPOSITORY_UPDATE_FAILED => trans('projectsquare-payment::my_account.fund_platform_account_invalid_amount_error'),
        ];

        return (isset($errorMessages[$errorCode])) ? $errorMessages[$errorCode] :  trans('projectsquare-payment::my_account.fund_platform_account_generic_error');
    }
}