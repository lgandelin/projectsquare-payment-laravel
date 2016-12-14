<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Commands;

use Illuminate\Console\Command;

class UpdatePlatformsStatuses extends Command
{
    protected $signature = 'projectsquare-payment:update-platforms-statuses';

    protected $description = 'Met à jour les statuts des plateformes';

    public function handle()
    {
        app()->make('UpdatePlatformsStatusesInteractor')->execute();

        $this->info('Mise à jour des statuts de toutes les plateformes effectuée !');
    }
}