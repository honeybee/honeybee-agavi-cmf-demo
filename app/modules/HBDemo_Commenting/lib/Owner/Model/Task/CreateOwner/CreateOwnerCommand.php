<?php

namespace HBDemo\Commenting\Owner\Model\Task\CreateOwner;

use Honeybee\Model\Task\CreateAggregateRoot\CreateAggregateRootCommand;

class CreateOwnerCommand extends CreateAggregateRootCommand
{
    public function getEventClass()
    {
        return OwnerCreatedEvent::CLASS;
    }
}
