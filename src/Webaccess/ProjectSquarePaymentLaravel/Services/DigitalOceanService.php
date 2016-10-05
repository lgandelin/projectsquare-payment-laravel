<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Services;

use Webaccess\ProjectSquarePayment\Services\RemoteInfrastructureGenerator;

class DigitalOceanService implements RemoteInfrastructureGenerator
{
    /**
     * @param $nodeIdentifier
     * @param $slug
     * @param $administratorEmail
     * @param $usersLimit
     * @internal param $usersCount
     */
    public function launchEnvCreation($nodeIdentifier, $slug, $administratorEmail, $usersLimit)
    {
        $fileName = env('ENVS_FOLDER') . $slug . '.txt';
        $fileContent = $nodeIdentifier . PHP_EOL . $slug . PHP_EOL . $administratorEmail . PHP_EOL . $usersLimit . PHP_EOL;
        file_put_contents($fileName, $fileContent);
    }

    /**
     * @param $nodeIdentifier
     * @param $slug
     * @param $administratorEmail
     * @param $usersLimit
     */
    public function launchAppCreation($nodeIdentifier, $slug, $administratorEmail, $usersLimit)
    {
        $fileName = env('APPS_FOLDER') . $slug . '.txt';
        $fileContent = $nodeIdentifier . PHP_EOL . $slug . PHP_EOL . $administratorEmail . PHP_EOL . $usersLimit . PHP_EOL;
        file_put_contents($fileName, $fileContent);
    }

    /**
     * @param $nodeIdentifier
     */
    public function launchNodeCreation($nodeIdentifier)
    {
        $fileName = env('NODES_FOLDER') . $nodeIdentifier . '.txt';
        $fileContent = $nodeIdentifier . PHP_EOL . "1" . PHP_EOL;
        file_put_contents($fileName, $fileContent);
    }
}