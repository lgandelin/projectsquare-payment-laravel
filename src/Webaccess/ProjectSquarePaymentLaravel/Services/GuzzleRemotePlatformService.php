<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Services;

use GuzzleHttp\Client;
use Webaccess\ProjectSquarePayment\Contracts\RemotePlatformService;
use Webaccess\ProjectSquarePayment\Entities\Platform;

class GuzzleRemotePlatformService implements RemotePlatformService
{
    private $apiToken;

    public function __construct($apiToken)
    {
        $this->apiToken = $apiToken;
    }

    /**
     * @param Platform $platform
     * @return mixed
     */
    public function getUsersLimit(Platform $platform)
    {
        $client = new Client(['base_uri' => $this->getPlatformURL($platform)]);
        $response = $client->get('/api/users_count');
        $body = json_decode($response->getBody());

        return $body->count;
    }

    /**
     * @param Platform $platform
     * @param $usersCount
     */
    public function updateUsersLimit(Platform $platform, $usersCount)
    {
        $client = new Client(['base_uri' => $this->getPlatformURL($platform)]);
        $response = $client->post('/api/update_users_count', [
            'json' => [
                'count' => $usersCount,
                'token' => $this->apiToken
            ]
        ]);
    }

    public function getPlatformURL(Platform $platform)
    {
        return 'http://' . $platform->getSlug() . '.projectsquare.io';
    }
}