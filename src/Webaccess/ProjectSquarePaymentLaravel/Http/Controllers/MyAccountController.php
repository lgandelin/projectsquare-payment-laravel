<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Webaccess\ProjectSquarePaymentLaravel\Services\PlatformManager;
use Webaccess\ProjectSquarePaymentLaravel\Utils\Logger;

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
        $usersCount = $request->users_count;
        $platform = $this->getCurrentPlatform();

        $actualUsersCount = 10; //@TODO : fetch actual users count from the platform

        try {
            $response = app()->make('UpdatePlatformUsersCountInteractor')->execute(new UpdatePlatformUsersCountRequest([
                'platformID' => $platform->id,
                'usersCount' => $usersCount,
                'actualUsersCount' => $actualUsersCount
            ]));

            return response()->json([
                'success' => $response->success,
                'error' => $response->errorCode
            ], 200);
        } catch (Exception $e) {
            Logger::error($e->getMessage(), $e->getFile(), $e->getLine(), $request->all());

            return response()->json([
                'success' => false,
                'error' => trans('projectsquare-payment::my_account.update_users_count_error'),
            ], 500);
        }
    }

    private function getCurrentPlatform()
    {
        $user = auth()->user();
        return (new PlatformManager())->getPlatformByID($user->platform_id);
    }
}