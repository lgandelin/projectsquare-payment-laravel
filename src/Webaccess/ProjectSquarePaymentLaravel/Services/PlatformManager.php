<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Services;

use Webaccess\ProjectSquarePaymentLaravel\Models\Node;
use Webaccess\ProjectSquarePaymentLaravel\Models\Platform;
use Webaccess\ProjectSquarePaymentLaravel\Utils\Logger;

class PlatformManager
{
    /**
     * @param $slug
     * @param $administratorEmail
     * @param $platformID
     */
    public function launchPlatformCreation($slug, $administratorEmail, $platformID)
    {
        if (!$nodeIdentifier = $this->getAvailableNodeIdentifier()) {
            $nodeIdentifier = $this->persistNewNode();

            $fileName = env('ENVS_FOLDER') . $slug . '.txt';
            $fileContent = $nodeIdentifier . PHP_EOL . $slug . PHP_EOL . $administratorEmail . PHP_EOL;
            file_put_contents($fileName, $fileContent);
        } else {
            $this->createApp($nodeIdentifier, $slug, $administratorEmail);
            $this->setNodeUnavailable($nodeIdentifier);
        }

        $this->updatePlatformNodeID($platformID, $nodeIdentifier);

        $this->createNextNode();
    }

    private function getAvailableNodeIdentifier()
    {
        if ($node = Node::where('available', '=', true)->orderBy('created_at', 'asc')->first()) {
            return $node->identifier;
        }

        return false;
    }

    /**
     * @param $nodeIdentifier
     * @param $slug
     * @param $administratorEmail
     */
    private function createApp($nodeIdentifier, $slug, $administratorEmail)
    {
        $fileName = env('APPS_FOLDER') . $slug . '.txt';
        $fileContent = $nodeIdentifier . PHP_EOL . $slug . PHP_EOL . $administratorEmail . PHP_EOL;
        file_put_contents($fileName, $fileContent);
    }

    private function createNextNode()
    {
        $nodeIdentifier = $this->persistNewNode();

        //Launch node generation
        $fileName = env('NODES_FOLDER') . $nodeIdentifier . '.txt';
        $fileContent = $nodeIdentifier . PHP_EOL . "1" . PHP_EOL;
        file_put_contents($fileName, $fileContent);
    }

    private function generateNodeIdentifier()
    {
        return uniqid();
    }

    /**
     * @param $platformID
     * @param $nodeIdentifier
     */
    private function updatePlatformNodeID($platformID, $nodeIdentifier)
    {
        $platform = $this->getPlatformByID($platformID);
        $node = Node::where('identifier', '=', $nodeIdentifier)->first();

        if ($platform && $node) {
            $platform->node_id = $node->id;
            $platform->save();
        } else {
            Logger::error('In updatePlatformNodeIdentifier method, the platformID was not found or the nodeIdentifier is incorrect', 'SignupController.php', '154', ['platformID' => $platformID, 'nodeIdentifier' => $nodeIdentifier]);
        }
    }

    private function persistNewNode()
    {
        $node = new Node();
        $node->identifier = $this->generateNodeIdentifier();
        $node->available = false;
        $node->save();

        return $node->identifier;
    }

    /**
     * @param $nodeIdentifier
     */
    private function setNodeUnavailable($nodeIdentifier)
    {
        $node = Node::where('identifier', '=', $nodeIdentifier)->first();
        $node->available = false;
        $node->save();
    }

    /**
     * @param $platformID
     */
    public function getPlatformByID($platformID)
    {
        return Platform::find($platformID);
    }
}