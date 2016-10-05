<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent;

use Webaccess\ProjectSquarePaymentLaravel\Models\Node;
use Webaccess\ProjectSquarePaymentLaravel\Models\Platform;

class EloquentNodeRepository
{
    public function getAvailableNodeIdentifier()
    {
        if ($node = Node::where('available', '=', true)->orderBy('created_at', 'asc')->first()) {
            return $node->identifier;
        }

        return false;
    }

    /**
     * @param $platformID
     * @param $nodeIdentifier
     */
    public function updatePlatformNodeID($platformID, $nodeIdentifier)
    {
        $platform = Platform::find($platformID);
        $node = Node::where('identifier', '=', $nodeIdentifier)->first();

        if ($platform && $node) {
            $platform->node_id = $node->id;
            $platform->save();
        }
    }

    public function persistNewNode()
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
    public function setNodeUnavailable($nodeIdentifier)
    {
        $node = Node::where('identifier', '=', $nodeIdentifier)->first();
        $node->available = false;
        $node->save();
    }

    private function generateNodeIdentifier()
    {
        return uniqid();
    }
}