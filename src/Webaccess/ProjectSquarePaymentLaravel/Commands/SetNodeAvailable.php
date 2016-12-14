<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Commands;

use Illuminate\Console\Command;
use Webaccess\ProjectSquarePaymentLaravel\Models\Node;

class SetNodeAvailable extends Command
{
    protected $signature = 'projectsquare-payment:set-node-available {identifier}';

    protected $description = 'Rendre une node disponible';

    public function handle()
    {
        $identifier = $this->argument('identifier');

        if ($node = Node::where('identifier', '=', $identifier)->first()) {
            $node->available = true;
            $node->save();
            $this->info('Node ' . $identifier . ' disponible !');
        } else {
            $this->error('Node ' . $identifier . ' non trouvée');
        }
    }
}
