<?php

namespace HBDemo\Commenting\Owner\Model\Task\ModifyOwner;

use Honeybee\Model\Task\ModifyAggregateRoot\ModifyAggregateRootCommand;

class ModifyOwnerCommand extends ModifyAggregateRootCommand
{
    public function getEventClass()
    {
        return OwnerModifiedEvent::CLASS;
    }
}
