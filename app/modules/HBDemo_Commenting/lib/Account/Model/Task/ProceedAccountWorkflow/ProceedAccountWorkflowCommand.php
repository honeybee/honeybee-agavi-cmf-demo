<?php

namespace HBDemo\Commenting\Account\Model\Task\ProceedAccountWorkflow;

use Honeybee\Model\Task\ProceedWorkflow\ProceedWorkflowCommand;

class ProceedAccountWorkflowCommand extends ProceedWorkflowCommand
{
    public function getEventClass()
    {
        return AccountWorkflowProceededEvent::CLASS;
    }
}
