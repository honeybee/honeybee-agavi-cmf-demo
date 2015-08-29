<?php

namespace Honeybee\SystemAccount\Fixture;

use Honeybee\Infrastructure\Fixture\Fixture;
use Honeybee\Infrastructure\Fixture\FixtureTargetInterface;

class Fixture_20150819120801_ImportDemoUser extends Fixture
{
    public function import(FixtureTargetInterface $fixture_target)
    {
        $this->copyFilesToTempLocation(__DIR__ . DIRECTORY_SEPARATOR . 'files');

        foreach ($this->getFixtureData() as $filename) {
            $this->importFixtureFromFile($filename);
        }
    }

    protected function getFixtureData()
    {
        return [
            __DIR__ . DIRECTORY_SEPARATOR . 'user-data.json'
        ];
    }
}
