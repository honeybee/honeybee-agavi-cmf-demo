<?php

namespace HBDemo\Commenting\Topic\Model\Task\CreateTopic;

use Honeybee\Model\Task\CreateAggregateRoot\CreateAggregateRootCommand;

class CreateTopicCommand extends CreateAggregateRootCommand
{
    public function getEventClass()
    {
        return TopicCreatedEvent::CLASS;
    }
}
