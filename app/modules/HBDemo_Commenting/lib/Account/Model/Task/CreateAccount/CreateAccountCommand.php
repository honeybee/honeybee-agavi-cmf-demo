<?php

namespace HBDemo\Commenting\Account\Model\Task\CreateAccount;

use Honeybee\Model\Task\CreateAggregateRoot\CreateAggregateRootCommand;

class CreateAccountCommand extends CreateAggregateRootCommand
{
    public function getEventClass()
    {
        return AccountCreatedEvent::CLASS;
    }
}
