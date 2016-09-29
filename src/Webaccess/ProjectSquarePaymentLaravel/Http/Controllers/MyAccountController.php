<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Webaccess\ProjectSquarePaymentLaravel\Services\PlatformManager;

class MyAccountController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $platform = (new PlatformManager())->getPlatformByID($user->platform_id);

        return view('projectsquare-payment::my_account.index', [
            'user' => $user,
            'platform' => $platform,
            'daily_cost' => app()->make('GetPlatformUsageAmountInteractor')->getDailyCost($platform->id),
            'monthly_cost' => app()->make('GetPlatformUsageAmountInteractor')->getMonthlyCost($platform->id),
        ]);
    }
}