<?php

namespace HBDemo\Commenting\Topic\Model\Task\MoveTopicNode;

use Honeybee\Model\Task\MoveAggregateRootNode\MoveAggregateRootNodeCommand;

class MoveTopicNodeCommand extends MoveAggregateRootNodeCommand
{
    public function getEventClass()
    {
        return TopicNodeMovedEvent::CLASS;
    }
}
