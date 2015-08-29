<?php

namespace HBDemo\Commenting\Migration\Elasticsearch;

use Honeybee\Infrastructure\Migration\ElasticsearchMigration;
use Honeybee\Infrastructure\Migration\MigrationTargetInterface;
use Honeybee\Infrastructure\Migration\MigrationInterface;

class Migration_20150810181512_CreateTopic extends ElasticsearchMigration
{
    protected function up(MigrationTargetInterface $migration_target)
    {
        $this->updateMappings($migration_target);
    }

    protected function down(MigrationTargetInterface $migration_target)
    {
    }

    public function getDescription($direction = MigrationInterface::MIGRATE_UP)
    {
        if ($direction === MigrationInterface::MIGRATE_UP) {
            return 'Will create the Elasticsearch mapping for Topic in the HBDemo_Commenting context.';
        }
    }

    public function isReversible()
    {
        return false;
    }

    protected function getIndexSettingsPath(MigrationTargetInterface $migration_target)
    {
    }

    protected function getTypeMappingPaths(MigrationTargetInterface $migration_target)
    {
        return [
            'hbdemo-commenting-topic-standard' => __DIR__ . DIRECTORY_SEPARATOR . 'topic-standard-20150810181512-mapping.json'
        ];
    }
}
