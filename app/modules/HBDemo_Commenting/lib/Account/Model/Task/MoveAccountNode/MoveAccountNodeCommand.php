<?php

namespace HBDemo\Commenting\Account\Model\Task\MoveAccountNode;

use Honeybee\Model\Task\MoveAggregateRootNode\MoveAggregateRootNodeCommand;

class MoveAccountNodeCommand extends MoveAggregateRootNodeCommand
{
    public function getEventClass()
    {
        return AccountNodeMovedEvent::CLASS;
    }
}
