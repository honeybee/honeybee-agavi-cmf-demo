<?php

namespace HoneybeeExtensions\Composer;

use Composer\Script\Event;
use Guzzle\Http\Client;

class DemoProjectHandler extends ProjectHandler
{
    public static function destroyData(Event $event)
    {
        $io = $event->getIO();
        $destroy_data = $io->askConfirmation('<options=bold>Are you sure you want to destroy all local data? [y,N]: </>', false);
        if (true === $destroy_data) {
            $client = new Client();
            $client->setDefaultOption('exceptions', false);
            $es_indices = self::DEFAULT_PROJECT_NAME . '.*';
            $couch_dbs = self::DEFAULT_PROJECT_NAME . '%2Bdomain_events';
            $io->write('-> deleting Elasticsearch indices "' . $es_indices . '"');
            $client->delete('http://localhost:9200/' . $es_indices)->send();
            $io->write('-> deleting CouchDb database "' . $couch_dbs . '"');
            $client->delete('http://127.0.0.1:5984/' . $couch_dbs)->send();
        }
    }

    public static function rebuildData(Event $event)
    {
        self::destroyData($event);
        MigrationHandler::runMigration(
            new Event(
                $event->getName(),
                $event->getComposer(),
                $event->getIO(),
                $event->isDevMode(),
                [ '--all' ]
            )
        );
        FixtureHandler::importFixture(
            new Event(
                $event->getName(),
                $event->getComposer(),
                $event->getIO(),
                $event->isDevMode(),
                [
                    '-target=honeybee.system_account::fixture::writer',
                    '-fixture=20150819120801:import_demo_user'
                ]
            )
        );
        FixtureHandler::importFixture(
            new Event(
                $event->getName(),
                $event->getComposer(),
                $event->getIO(),
                $event->isDevMode(),
                [
                    '-target=hbdemo.commenting::fixture::writer',
                    '-fixture=20150810231335:initial_test_data'
                ]
            )
        );
    }
}
