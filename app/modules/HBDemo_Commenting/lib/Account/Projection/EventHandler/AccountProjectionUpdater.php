<?php

namespace HBDemo\Commenting\Account\Projection\EventHandler;

use Honeybee\Infrastructure\DataAccess\DataAccessServiceInterface;
use Honeybee\Infrastructure\DataAccess\Storage\StorageWriterMap;
use Honeybee\Infrastructure\DataAccess\Query\QueryServiceMap;
use Honeybee\Infrastructure\Config\ConfigInterface;
use Honeybee\Infrastructure\Command\Bus\CommandBusInterface;
use Honeybee\Infrastructure\Event\EventInterface;
use Honeybee\Projection\ProjectionTypeMap;
use Honeybee\Projection\EventHandler\RelationProjectionUpdater;
use Honeybee\Model\Aggregate\AggregateRootTypeMap;
use Psr\Log\LoggerInterface;
use HBDemo\Commenting\Account\Model\Task\ProceedAccountWorkflow\ProceedAccountWorkflowCommand;
use HBDemo\Commenting\Owner\Model\Task\ProceedOwnerWorkflow\OwnerWorkflowProceededEvent;

class AccountProjectionUpdater extends RelationProjectionUpdater
{
    protected $command_bus;

    public function __construct(
        ConfigInterface $config,
        LoggerInterface $logger,
        StorageWriterMap $storage_writer_map,
        QueryServiceMap $query_service_map,
        ProjectionTypeMap $projection_type_map,
        AggregateRootTypeMap $aggregate_root_type_map,
        CommandBusInterface $command_bus
    ) {
        parent::__construct(
            $config,
            $logger,
            $storage_writer_map,
            $query_service_map,
            $projection_type_map,
            $aggregate_root_type_map
        );

        $this->command_bus = $command_bus;
    }

    public function handleEvent(EventInterface $event)
    {
        $affected_entities = parent::handleEvent($event);

        if ($event instanceof OwnerWorkflowProceededEvent
            && $event->getWorkflowState() == 'deleted'
        ) {
            $type_prefix = $this->config->get('projection_type');
            $aggregate_root_type = get_class($this->aggregate_root_type_map->getItem($type_prefix));
            foreach ($affected_entities as $affected_entity) {
                $command = new ProceedAccountWorkflowCommand(
                    [
                        'aggregate_root_type' => $aggregate_root_type,
                        'aggregate_root_identifier' => $affected_entity->getIdentifier(),
                        'known_revision' => $affected_entity->getRevision(),
                        'current_state_name' => $affected_entity->getWorkflowState(),
                        'event_name' => 'delete'
                    ]
                );
                $this->command_bus->post($command);
            }
        }

        return $affected_entities;
    }
}
