<?php

namespace HBDemo\Commenting\Comment\Model\Task\ProceedCommentWorkflow;

use Honeybee\Model\Task\ProceedWorkflow\ProceedWorkflowCommand;

class ProceedCommentWorkflowCommand extends ProceedWorkflowCommand
{
    public function getEventClass()
    {
        return CommentWorkflowProceededEvent::CLASS;
    }
}
