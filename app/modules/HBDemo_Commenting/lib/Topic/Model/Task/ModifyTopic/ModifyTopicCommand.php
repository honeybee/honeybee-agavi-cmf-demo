<?php

namespace HBDemo\Commenting\Topic\Model\Task\ModifyTopic;

use Honeybee\Model\Task\ModifyAggregateRoot\ModifyAggregateRootCommand;

class ModifyTopicCommand extends ModifyAggregateRootCommand
{
    public function getEventClass()
    {
        return TopicModifiedEvent::CLASS;
    }
}
