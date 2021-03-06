<?php

namespace HBDemo\Commenting\Topic\Model\Task\MoveTopicNode;

use HBDemo\Commenting\Topic\Model\Aggregate\TopicType;
use Honeybee\Infrastructure\Event\Bus\EventBusInterface;
use Honeybee\Model\Task\MoveAggregateRootNode\MoveAggregateRootNodeCommandHandler;
use Honeybee\Infrastructure\DataAccess\DataAccessServiceInterface;
use Honeybee\Infrastructure\Filesystem\FilesystemServiceInterface;
use Psr\Log\LoggerInterface;

class MoveTopicNodeCommandHandler extends MoveAggregateRootNodeCommandHandler
{
    public function __construct(
        TopicType $topic_type,
        DataAccessServiceInterface $data_access_service,
        FilesystemServiceInterface $filesystem_service,
        EventBusInterface $event_bus,
        LoggerInterface $logger
    ) {
        parent::__construct($topic_type, $data_access_service, $filesystem_service, $event_bus, $logger);
    }
}
