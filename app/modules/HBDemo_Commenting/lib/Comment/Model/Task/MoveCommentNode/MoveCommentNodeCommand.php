<?php

namespace HBDemo\Commenting\Comment\Model\Task\MoveCommentNode;

use Honeybee\Model\Task\MoveAggregateRootNode\MoveAggregateRootNodeCommand;

class MoveCommentNodeCommand extends MoveAggregateRootNodeCommand
{
    public function getEventClass()
    {
        return CommentNodeMovedEvent::CLASS;
    }
}
