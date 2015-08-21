<?php

namespace HBDemo\Commenting\Account\Model\Task\ModifyAccount;

use Honeybee\Model\Task\ModifyAggregateRoot\ModifyAggregateRootCommand;

class ModifyAccountCommand extends ModifyAggregateRootCommand
{
    public function getEventClass()
    {
        return AccountModifiedEvent::CLASS;
    }
}
