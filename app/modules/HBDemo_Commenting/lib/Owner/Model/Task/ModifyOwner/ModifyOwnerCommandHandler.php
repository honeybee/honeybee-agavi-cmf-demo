<?php

namespace HBDemo\Commenting\Owner\Model\Task\ModifyOwner;

use HBDemo\Commenting\Owner\Model\Aggregate\OwnerType;
use Honeybee\Infrastructure\Event\Bus\EventBusInterface;
use Honeybee\Model\Task\ModifyAggregateRoot\ModifyAggregateRootCommandHandler;
use Honeybee\Infrastructure\DataAccess\DataAccessServiceInterface;
use Honeybee\Infrastructure\Filesystem\FilesystemServiceInterface;
use Psr\Log\LoggerInterface;

class ModifyOwnerCommandHandler extends ModifyAggregateRootCommandHandler
{
    public function __construct(
        OwnerType $owner_type,
        DataAccessServiceInterface $data_access_service,
        FilesystemServiceInterface $filesystem_service,
        EventBusInterface $event_bus,
        LoggerInterface $logger
    ) {
        parent::__construct($owner_type, $data_access_service, $filesystem_service, $event_bus, $logger);
    }
}
