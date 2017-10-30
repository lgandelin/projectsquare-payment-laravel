<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use stdClass;

class RefundEmailJob implements ShouldQueue
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
        $email = env('CONTACT_EMAIL');
        $administratorEmail = $this->emailData->administratorEmail;
        $platformSlug = $this->emailData->platformSlug;

        Mail::send('projectsquare-payment::emails.refund_admin', array('platformSlug' => $platformSlug, 'administratorEmail' => $administratorEmail), function ($message) use ($email) {
            $message->to($email)
                ->subject('[projectsquare] Demande de remboursement d\'un abonnement Projectsquare');
        });
    }
}