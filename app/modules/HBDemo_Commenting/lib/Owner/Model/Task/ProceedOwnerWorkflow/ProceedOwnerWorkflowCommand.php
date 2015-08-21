<?php

namespace HBDemo\Commenting\Owner\Model\Task\ProceedOwnerWorkflow;

use Honeybee\Model\Task\ProceedWorkflow\ProceedWorkflowCommand;

class ProceedOwnerWorkflowCommand extends ProceedWorkflowCommand
{
    public function getEventClass()
    {
        return OwnerWorkflowProceededEvent::CLASS;
    }
}
