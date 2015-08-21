<?php

namespace HBDemo\Commenting\Comment\Model\Task\CreateComment;

use Honeybee\Model\Task\CreateAggregateRoot\CreateAggregateRootCommand;

class CreateCommentCommand extends CreateAggregateRootCommand
{
    public function getEventClass()
    {
        return CommentCreatedEvent::CLASS;
    }
}
