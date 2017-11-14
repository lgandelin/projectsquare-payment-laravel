<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use stdClass;

class CancelEmailJob implements ShouldQueue
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
        $administratorEmail = $this->emailData->administratorEmail;
        $platformSlug = $this->emailData->platformSlug;
        $endDate = $this->emailData->endDate;

        Mail::send('projectsquare-payment::emails.cancel', array('platformSlug' => $platformSlug, 'administratorEmail' => $administratorEmail, 'endDate' => $endDate), function ($message) use ($administratorEmail) {
            $message->to($administratorEmail)
                ->subject('[projectsquare] Annulation de votre abonnement Projectsquare');
        });

        Mail::send('projectsquare-payment::emails.cancel_admin', array('platformSlug' => $platformSlug, 'administratorEmail' => $administratorEmail, 'endDate' => $endDate), function ($message) {
            $message->to(env('CONTACT_EMAIL'))
                ->subject('[projectsquare] Annulation d\'un abonnement Projectsquare');
        });
    }
}