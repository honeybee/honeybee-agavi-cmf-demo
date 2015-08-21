<?php

namespace HBDemo\Commenting\Topic\Model\Task\ProceedTopicWorkflow;

use Honeybee\Model\Task\ProceedWorkflow\ProceedWorkflowCommand;

class ProceedTopicWorkflowCommand extends ProceedWorkflowCommand
{
    public function getEventClass()
    {
        return TopicWorkflowProceededEvent::CLASS;
    }
}
