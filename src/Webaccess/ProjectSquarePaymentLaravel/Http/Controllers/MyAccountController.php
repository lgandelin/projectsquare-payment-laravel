<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Webaccess\ProjectSquarePaymentLaravel\Services\PlatformManager;
use Webaccess\ProjectSquarePaymentLaravel\Utils\Logger;
use Webaccess\ProjectSquarePayment\Requests\Platforms\FundPlatformAccountRequest;
use Webaccess\ProjectSquarePayment\Responses\Platforms\FundPlatformAccountResponse;
use Webaccess\ProjectSquarePayment\Requests\Platforms\UpdatePlatformUsersCountRequest;
use Webaccess\ProjectSquarePayment\Responses\Platforms\UpdatePlatformUsersCountResponse;
use GuzzleHttp\Client;

class MyAccountController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $platform = $this->getCurrentPlatform();

        return view('projectsquare-payment::my_account.index', [
            'user' => $user,
            'platform' => $platform,
            'daily_cost' => app()->make('GetPlatformUsageAmountInteractor')->getDailyCost($platform->id),
            'monthly_cost' => app()->make('GetPlatformUsageAmountInteractor')->getMonthlyCost($platform->id),
        ]);
    }

    public function udpate_users_count(Request $request)
    {
        $platform = $this->getCurrentPlatform();
        $usersCount = $request->users_count;

        try {
            $response = app()->make('UpdatePlatformUsersCountInteractor')->execute(new UpdatePlatformUsersCountRequest([
                'platformID' => $platform->id,
                'usersCount' => $usersCount,
                'actualUsersCount' => $this->getUsersCountFromPlatform($platform->id)
            ]));

            if ($response->success) {
                $this->updateUsersCountInPlatform($platform->id, $usersCount);
            }

            return response()->json([
                'success' => $response->success,
                'error' => ($response->errorCode) ? $this->getErrorMessageUpdateUsersCount($response->errorCode) : null,
                'daily_cost' => app()->make('GetPlatformUsageAmountInteractor')->getDailyCost($platform->id),
                'monthly_cost' => app()->make('GetPlatformUsageAmountInteractor')->getMonthlyCost($platform->id),
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
        $platform = $this->getCurrentPlatform();

        try {
            $response = app()->make('FundPlatformAccountInteractor')->execute(new FundPlatformAccountRequest([
                'platformID' => $platform->id,
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

    private function getCurrentPlatform()
    {
        $user = auth()->user();
        return (new PlatformManager())->getPlatformByID($user->platform_id);
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

    private function getUsersCountFromPlatform($platformID)
    {
        $client = new Client(['base_uri' => PlatformManager::getPlatformURL($platformID)]);
        $response = $client->get('/api/users_count');
        $body = json_decode($response->getBody());

        return $body->count;
    }

    private function updateUsersCountInPlatform($platformID, $usersCount)
    {
        $client = new Client(['base_uri' => PlatformManager::getPlatformURL($platformID)]);
        $response = $client->post('/api/update_users_count', [
            'json' => [
                'count' => $usersCount,
                'token' => env('API_TOKEN')
            ]
        ]);
    }
}