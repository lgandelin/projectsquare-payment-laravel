<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Services;

use GuzzleHttp\Client;
use Webaccess\ProjectSquarePayment\Repositories\PlatformRepository;

class PlatformAPIGateway
{
    private $platformRepository;

    public function __construct(PlatformRepository $platformRepository)
    {
        $this->platformRepository = $platformRepository;
    }

    /**
     * @param $platformID
     * @return mixed
     */
    public function getUsersCountFromRealPlatform($platformID)
    {
        $client = new Client(['base_uri' => $this->getPlatformURL($platformID)]);
        $response = $client->get('/api/users_count');
        $body = json_decode($response->getBody());

        return $body->count;
    }

    /**
     * @param $platformID
     * @param $usersCount
     */
    public function updateUsersCountInRealPlatform($platformID, $usersCount)
    {
        $client = new Client(['base_uri' => $this->getPlatformURL($platformID)]);
        $response = $client->post('/api/update_users_count', [
            'json' => [
                'count' => $usersCount,
                'token' => env('API_TOKEN')
            ]
        ]);
    }

    private function getPlatformURL($platformID)
    {
        if ($platform = $this->platformRepository->getByID($platformID)) {
            return 'http://' . $platform->getSlug() . '.projectsquare.io';
        }

        return false;
    }

    /**
     * @param $slug
     * @param $administratorEmail
     * @param $usersCount
     * @param $nodeIdentifier
     */
    public function launchEnvCreation($slug, $administratorEmail, $usersCount, $nodeIdentifier)
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