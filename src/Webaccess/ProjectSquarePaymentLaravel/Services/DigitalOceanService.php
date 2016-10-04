<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Services;

class DigitalOceanService
{
    /**
     * @param $slug
     * @param $administratorEmail
     * @param $usersCount
     * @param $nodeIdentifier
     */
    public static function launchEnvCreation($slug, $administratorEmail, $usersCount, $nodeIdentifier)
    {
        $fileName = env('ENVS_FOLDER') . $slug . '.txt';
        $fileContent = $nodeIdentifier . PHP_EOL . $slug . PHP_EOL . $administratorEmail . PHP_EOL . $usersCount . PHP_EOL;
        file_put_contents($fileName, $fileContent);
    }

    /**
     * @param $nodeIdentifier
     * @param $slug
     * @param $administratorEmail
     * @param $usersLimit
     */
    public static function launchAppCreation($nodeIdentifier, $slug, $administratorEmail, $usersLimit)
    {
        $fileName = env('APPS_FOLDER') . $slug . '.txt';
        $fileContent = $nodeIdentifier . PHP_EOL . $slug . PHP_EOL . $administratorEmail . PHP_EOL . $usersLimit . PHP_EOL;
        file_put_contents($fileName, $fileContent);
    }

    /**
     * @param $nodeIdentifier
     */
    public static function launchNodeCreation($nodeIdentifier)
    {
        $fileName = env('NODES_FOLDER') . $nodeIdentifier . '.txt';
        $fileContent = $nodeIdentifier . PHP_EOL . "1" . PHP_EOL;
        file_put_contents($fileName, $fileContent);
    }
}