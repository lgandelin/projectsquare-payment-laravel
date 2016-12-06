<?php

namespace Webaccess\ProjectSquarePaymentLaravel\Repositories\Eloquent;

use Webaccess\ProjectSquarePaymentLaravel\Models\Node;
use Webaccess\ProjectSquarePayment\Entities\Node as NodeEntity;
use Webaccess\ProjectSquarePayment\Repositories\NodeRepository;

class EloquentNodeRepository implements NodeRepository
{
    public function getAvailableNodeIdentifier()
    {
        if ($node = Node::where('available', '=', true)->orderBy('created_at', 'asc')->first()) {
            return $node->identifier;
        }

        return false;
    }

    public function getByID($nodeID)
    {
        return Node::find($nodeID);
    }

    public function persist(NodeEntity $node)
    {
        $nodeModel = new Node();
        $nodeModel->identifier = $node->getIdentifier();
        $nodeModel->available = $node->isAvailable();
        $nodeModel->save();

        return $nodeModel->id;
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
}