<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use stdClass;

class PaymentEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emailData;

    /**
     * Create a new job instance.
     * @param stdClass $emailData
     */
    public function __construct(StdClass $emailData)
    {
        $this->emailData = $emailData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->emailData->administratorEmail;
        $url = $this->emailData->platformSlug;

        Mail::send('projectsquare-payment::emails.payment_email', array('url' => $url), function ($message) use ($email) {
            $message->to($email)
                ->subject('[projectsquare] S\'abonner à Projectsquare');
        });
    }
}