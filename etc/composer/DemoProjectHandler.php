<?php

namespace HoneybeeExtensions\Composer;

use Composer\Script\Event;
use Guzzle\Http\Client;

class DemoProjectHandler extends ProjectHandler
{
    public static function destroyData(Event $event)
    {
        $io = $event->getIO();
        if (!$event->isDevMode()) {
            $io->write('This script is only supported in development mode. Exiting.');
            return;
        }

        $destroy_data = $io->askConfirmation('<options=bold>Are you sure you want to destroy all local data? [y,N]: </>', false);
        if (true === $destroy_data) {
            $client = new Client();
            $client->setDefaultOption('exceptions', false);
            $es_indices = self::DEFAULT_PROJECT_NAME . '.*';
            $couch_event_db = self::DEFAULT_PROJECT_NAME . '%2Bdomain_events';
            $couch_process_db = self::DEFAULT_PROJECT_NAME . '%2Bprocess_states';
            $io->write('-> deleting Elasticsearch indices "' . $es_indices . '"');
            $client->delete('http://localhost:9200/' . $es_indices)->send();
            $io->write('-> deleting CouchDb database "' . $couch_event_db . '"');
            $client->delete('http://127.0.0.1:5984/' . $couch_event_db)->send();
            $io->write('-> deleting CouchDb database "' . $couch_process_db . '"');
            $client->delete('http://127.0.0.1:5984/' . $couch_process_db)->send();
        }

        return $destroy_data;
    }

    public static function rebuildData(Event $event)
    {
        $io = $event->getIO();
        if (!$event->isDevMode()) {
            $io->write('This script is only supported in development mode. Exiting.');
            return;
        }

        $destroyed = self::destroyData($event);
        if ($destroyed) {
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
}
