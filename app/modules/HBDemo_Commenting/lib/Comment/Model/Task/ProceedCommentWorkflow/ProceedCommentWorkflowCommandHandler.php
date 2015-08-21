<?php

namespace HBDemo\Commenting\Comment\Model\Task\ProceedCommentWorkflow;

use HBDemo\Commenting\Comment\Model\Aggregate\CommentType;
use Honeybee\Infrastructure\Event\Bus\EventBusInterface;
use Honeybee\Model\Task\ProceedWorkflow\ProceedWorkflowCommandHandler;
use Honeybee\Infrastructure\DataAccess\DataAccessServiceInterface;
use Honeybee\Infrastructure\Filesystem\FilesystemServiceInterface;
use Psr\Log\LoggerInterface;

class ProceedCommentWorkflowCommandHandler extends ProceedWorkflowCommandHandler
{
    public function __construct(
        CommentType $comment_type,
        DataAccessServiceInterface $data_access_service,
        FilesystemServiceInterface $filesystem_service,
        EventBusInterface $event_bus,
        LoggerInterface $logger
    ) {
        parent::__construct($comment_type, $data_access_service, $filesystem_service, $event_bus, $logger);
    }
}
