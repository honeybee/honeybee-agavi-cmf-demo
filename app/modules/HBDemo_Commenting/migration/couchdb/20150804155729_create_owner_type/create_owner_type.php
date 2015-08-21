<?php

namespace HBDemo\Commenting\Migration\CouchDb;

use Honeybee\Infrastructure\Migration\CouchDbMigration;
use Honeybee\Infrastructure\Migration\MigrationTargetInterface;
use Honeybee\Infrastructure\Migration\MigrationInterface;

class Migration_20150804155729_CreateOwnerType extends CouchDbMigration
{
    protected function up(MigrationTargetInterface $migration_target)
    {
        $this->updateDesignDoc($migration_target);
    }

    protected function down(MigrationTargetInterface $migration_target)
    {
        $this->deleteDesignDoc($migration_target);
    }

    public function getDescription($direction = MigrationInterface::MIGRATE_UP)
    {
        if ($direction === MigrationInterface::MIGRATE_UP) {
            return 'Will add Owner type design docs to the CouchDb database for the HBDemo_Commenting context.';
        }
        return 'Will delete Owner type design docs in the CouchDb database HBDemo_Commenting context.';
    }

    public function isReversible()
    {
        return true;
    }

    protected function getViewsDirectory()
    {
        return __DIR__;
    }

    protected function getDesignDocName()
    {
        return 'hbdemo-commenting-owner';
    }
}
