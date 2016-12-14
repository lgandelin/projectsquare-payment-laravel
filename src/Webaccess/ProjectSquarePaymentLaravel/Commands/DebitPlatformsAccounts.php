<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Commands;

use Illuminate\Console\Command;

class DebitPlatformsAccounts extends Command
{
    protected $signature = 'projectsquare-payment:debit-platforms-accounts';

    protected $description = 'Débite les comptes de leur coût quotidien pour toutes les plateformes';

    public function handle()
    {
        app()->make('DebitPlatformsAccountsInteractor')->execute();

        $this->info('Débit de toutes les plateformes effectué !');
    }
}
