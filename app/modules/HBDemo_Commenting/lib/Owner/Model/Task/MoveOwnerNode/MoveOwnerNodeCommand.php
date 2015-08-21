<?php

namespace HBDemo\Commenting\Owner\Model\Task\MoveOwnerNode;

use Honeybee\Model\Task\MoveAggregateRootNode\MoveAggregateRootNodeCommand;

class MoveOwnerNodeCommand extends MoveAggregateRootNodeCommand
{
    public function getEventClass()
    {
        return OwnerNodeMovedEvent::CLASS;
    }
}
