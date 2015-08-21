<?php

namespace HBDemo\Commenting\Account\Model\Task\CreateAccount;

use HBDemo\Commenting\Account\Model\Aggregate\AccountType;
use Honeybee\Infrastructure\Event\Bus\EventBusInterface;
use Honeybee\Model\Task\CreateAggregateRoot\CreateAggregateRootCommandHandler;
use Honeybee\Infrastructure\DataAccess\DataAccessServiceInterface;
use Honeybee\Infrastructure\Filesystem\FilesystemServiceInterface;
use Psr\Log\LoggerInterface;

class CreateAccountCommandHandler extends CreateAggregateRootCommandHandler
{
    public function __construct(
        AccountType $account_type,
        DataAccessServiceInterface $data_access_service,
        FilesystemServiceInterface $filesystem_service,
        EventBusInterface $event_bus,
        LoggerInterface $logger
    ) {
        parent::__construct($account_type, $data_access_service, $filesystem_service, $event_bus, $logger);
    }
}
