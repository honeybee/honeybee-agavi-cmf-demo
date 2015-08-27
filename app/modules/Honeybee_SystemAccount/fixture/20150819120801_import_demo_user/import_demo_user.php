<?php

namespace Honeybee\SystemAccount\Fixture;

use Honeybee\Infrastructure\Fixture\Fixture;
use Honeybee\Infrastructure\Fixture\FixtureTargetInterface;

class Fixture_20150819120801_ImportDemoUser extends Fixture
{
    public function import(FixtureTargetInterface $fixture_target)
    {
        $this->copyFixtureAssetsToTempLocation(__DIR__ . DIRECTORY_SEPARATOR . 'assets');

        foreach ($this->getFixtureFiles() as $filename) {
            $this->importFixtureFile($filename);
        }
    }

    protected function getFixtureFiles()
    {
        return [
            __DIR__ . DIRECTORY_SEPARATOR . 'user-data.json'
        ];
    }
}
