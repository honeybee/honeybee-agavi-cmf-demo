<?php

namespace HBDemo\Commenting\Migration\Elasticsearch;

use Honeybee\Infrastructure\Migration\ElasticsearchMigration;
use Honeybee\Infrastructure\Migration\MigrationTargetInterface;
use Honeybee\Infrastructure\Migration\MigrationInterface;

class Migration_20150804155706_InitViewStore extends ElasticsearchMigration
{
    protected function up(MigrationTargetInterface $migration_target)
    {
        $this->createIndexIfNotExists($migration_target);
    }

    protected function down(MigrationTargetInterface $migration_target)
    {
        $this->deleteIndex($migration_target);
    }

    public function getDescription($direction = MigrationInterface::MIGRATE_UP)
    {
        if ($direction === MigrationInterface::MIGRATE_UP) {
            return 'Will create the Elasticsearch index for the HBDemo_Commenting context.';
        }
        return 'Will delete the Elasticsearch index for the HBDemo_Commenting context.';
    }

    public function isReversible()
    {
        return true;
    }

    protected function getIndexSettingsPath(MigrationTargetInterface $migration_target)
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'index-settings.json';
    }

    protected function getTypeMappingPaths(MigrationTargetInterface $migration_target)
    {
    }
}
