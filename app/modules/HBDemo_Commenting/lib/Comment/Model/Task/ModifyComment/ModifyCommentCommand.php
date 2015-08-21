<?php

namespace HBDemo\Commenting\Comment\Model\Task\ModifyComment;

use Honeybee\Model\Task\ModifyAggregateRoot\ModifyAggregateRootCommand;

class ModifyCommentCommand extends ModifyAggregateRootCommand
{
    public function getEventClass()
    {
        return CommentModifiedEvent::CLASS;
    }
}
