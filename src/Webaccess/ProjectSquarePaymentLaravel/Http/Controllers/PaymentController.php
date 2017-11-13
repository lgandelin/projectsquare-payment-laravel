<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Webaccess\ProjectSquarePaymentLaravel\Jobs\CancelEmailJob;
use Webaccess\ProjectSquarePaymentLaravel\Jobs\RefundEmailJob;
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
        $platform = $this->platformRepository->getByID($this->getCurrentPlatformID());
        $user = auth()->user();
        $subscription = $user->subscription('user');

        if ($subscription && !$subscription->onTrial()) {
            $request->session()->flash('error', trans('projectsquare-payment::payment.subscription_in_progress'));
            return redirect()->route('my_account');
        }

        return view('projectsquare-payment::payment.index', [
            'user' => auth()->user(),
            'users_count' => $platform->getUsersCount(),
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

    public function subscribe(Request $request)
    {
        try {
            $platform = $this->platformRepository->getByID($this->getCurrentPlatformID());
            $user = auth()->user();
            $user->newSubscription('user', 'user')->skipTrial()->quantity($platform->getUsersCount())->create($request->stripeToken);
            $user->newSubscription('platform', 'platform')->skipTrial()->quantity(1)->create($request->stripeToken);

            $request->session()->flash('confirmation', trans('projectsquare-payment::payment.payment_success'));
        } catch (\Exception $e) {
            $request->session()->flash('error', trans('projectsquare-payment::payment.payment_error'));
        }

        return redirect()->route('my_account');
    }

    public function refund(Request $request)
    {
        try {
            $platform = $this->platformRepository->getByID($this->getCurrentPlatformID());
            $user = auth()->user();

            $user->subscription('user')->cancel();
            $user->subscription('platform')->cancel();

            $emailData = (object)[
                'administratorEmail' => $user->email,
                'platformSlug' => $platform->getSlug(),
            ];

            RefundEmailJob::dispatch($emailData)->onQueue('emails');

            $request->session()->flash('confirmation', trans('projectsquare-payment::payment.refund_success'));
        } catch (\Exception $e) {
            $request->session()->flash('error', trans('projectsquare-payment::payment.refund_error'));
        }

        $this->cancel($request);
    }

    public function cancel(Request $request)
    {
        try {
            $platform = $this->platformRepository->getByID($this->getCurrentPlatformID());
            $user = auth()->user();

            $user->subscription('user')->cancel();
            $user->subscription('platform')->cancel();

            $emailData = (object) [
                'administratorEmail' => $user->email,
                'platformSlug' => $platform->getSlug(),
                'endDate' => $user->subscription('user')->ends_at->format('d/m/Y'),
            ];

            CancelEmailJob::dispatch($emailData)->onQueue('emails');

            $request->session()->flash('confirmation', trans('projectsquare-payment::payment.cancel_success'));
        } catch (\Exception $e) {
            $request->session()->flash('error', trans('projectsquare-payment::payment.cancel_error'));
        }

        return redirect()->route('my_account');
    }

    private function getCurrentPlatformID()
    {
        $user = auth()->user();

        return ($user) ? $user->platform_id : false;
    }
}