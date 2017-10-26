<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent\EloquentPlatformRepository;

class PaymentController extends Controller
{
    public $transactionRepository;

    public function __construct()
    {
        $this->platformRepository = new EloquentPlatformRepository();
    }

    public function index(Request $request)
    {
        return view('projectsquare-payment::payment.index', [
            'user' => auth()->user(),
            'monthly_cost' => app()->make('GetPlatformUsageAmountInteractor')->getMonthlyCost($this->getCurrentPlatformID()),
        ]);
    }

    public function invoice($invoiceID)
    {
        error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

        $user = auth()->user();
        return $user->downloadInvoice($invoiceID, [
            'vendor'  => 'WEB@CCESS',
            'product' => 'Plateforme Projectsquare',
        ]);
    }

    public function pay(Request $request)
    {
        try {
            $platform = $this->platformRepository->getByID($this->getCurrentPlatformID());
            $user = auth()->user();
            $user->newSubscription('user', 'user')->skipTrial()->quantity($platform->getUsersCount())->create($request->stripeToken);
            $user->tab('Platform fixed cost', $platform->getPlatformMonthlyCost() * 100);

            $request->session()->flash('confirmation', trans('projectsquare-payment::payment.payment_success'));
        } catch (\Exception $e) {
            $request->session()->flash('error', trans('projectsquare-payment::payment.payment_error'));
        }

        return redirect()->route('my_account');
    }

    public function cancel_subscription(Request $request)
    {
        $user = auth()->user();
        $user->subscription('user')->cancel();

        return redirect()->route('my_account');
    }

    private function getCurrentPlatformID()
    {
        $user = auth()->user();

        return ($user) ? $user->platform_id : false;
    }
}