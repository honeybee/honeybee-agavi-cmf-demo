<?php

namespace HBDemo\Commenting\Migration\Elasticsearch;

use Honeybee\Infrastructure\Migration\ElasticsearchMigration;
use Honeybee\Infrastructure\Migration\MigrationTargetInterface;
use Honeybee\Infrastructure\Migration\MigrationInterface;

class Migration_20150810224420_CreateComment extends ElasticsearchMigration
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
            return 'Will create the Elasticsearch mapping for Comment in the HBDemo_Commenting context.';
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
            'hbdemo-commenting-comment-standard' => __DIR__ . DIRECTORY_SEPARATOR . 'comment-standard-20150810224420-mapping.json'
        ];
    }
}
