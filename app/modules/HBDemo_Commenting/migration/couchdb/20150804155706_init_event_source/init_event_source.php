<?php

namespace HBDemo\Commenting\Migration\CouchDb;

use Honeybee\Infrastructure\Migration\CouchDbMigration;
use Honeybee\Infrastructure\Migration\MigrationTargetInterface;
use Honeybee\Infrastructure\Migration\MigrationInterface;

class Migration_20150804155706_InitEventSource extends CouchDbMigration
{
    protected function up(MigrationTargetInterface $migration_target)
    {
        $this->createDatabaseIfNotExists($migration_target);
    }

    protected function down(MigrationTargetInterface $migration_target)
    {
        $this->deleteDatabase($migration_target);
    }

    public function getDescription($direction = MigrationInterface::MIGRATE_UP)
    {
        if ($direction === MigrationInterface::MIGRATE_UP) {
            return 'Will initialise a CouchDb database for the HBDemo_Commenting context.';
        }
        return 'Will deinit the CouchDb database for the HBDemo_Commenting context.';
    }

    public function isReversible()
    {
        return true;
    }

    protected function getViewsDirectory()
    {
    }

    protected function getDesignDocName()
    {
    }
}
