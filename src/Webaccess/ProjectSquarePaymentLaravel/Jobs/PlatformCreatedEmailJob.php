<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PlatformCreatedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = '';
        Mail::send('projectsquare-payment::emails.message_created', array(), function ($message) use ($email) {
            $message->to($email)
                ->subject('[projectsquare] Un nouveau message vient d\'être envoyé sur la plateforme');
        });
    }
}