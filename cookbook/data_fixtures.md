#Data Fixtures
When developing an application, data fixtures are particularly helpful so we can focus on feature development instead of data entry. They can also be useful when setting up testing in a system. 

##Creating a fixture
Fixture classes are structured in a similar way to migration classes. We are able to generate fixture classes using another convenient command line utility.

```shell
composer fixture-create
```

This will ask you for the target where you would like to create a fixture, so we will choose `hbdemo.commenting::fixture::writer` and a *CamelCase* name for the fixture class such as `InitialTestData`. A PHP fixture file will be then generated in the module's `fixture` directory which we can customise to handle the data importing if required.

##Generating data
Since we have configured our aggregate root types in a structured way based on [Trellis][1], we can also generate fake data easily. Sensible human understandable fake data can be printed to the console or written to a target JSON file.

###Owner data
The **Owner** has no relationships to other entity types, so the generated data does not require any modification. 

```shell
composer fixture-generate
# you can use <your fixture folder>/owner-data.json as a filename
```

The generated data will look like this (snippet), which you should copy into the fixture folder.

```json
{
    "hbdemo.commenting.owner": [
        {
            "identifier": "hbdemo.commenting.owner-25e446d5-cce1-3439-b676-1650680c579d-de_DE-33697",
            "@type": "HBDemo\\Commenting\\Owner\\Model\\Aggregate\\Owner",
            "revision": 97477,
            "uuid": "25e446d5-cce1-3439-b676-1650680c579d",
            "short_id": 38492,
            "language": "de_DE",
            "version": 33697,
            "name": "Hartmut Finke-Beer",
            "email": "uvollbrecht@sager.com",
            "password_hash": "atque et omnis sequiatque et omnis sequiatque et omnis sequi",
            "authorization_token": "de83e169d2a6f8f94ee7",
            "authorization_expires": "1976-09-19T19:03:58.000000+00:00",
            "images": [
                {
	                "location": "owner_image.jpg",
	                "title": "Ratione est quia et modi voluptatum voluptates.",
	                "caption": "ut est ea",
	                "copyright": "non inventore et",
	                "copyright_url": "https://jacobijackel.com/sed-et-est-pariatur.html",
	                "source": "tempora non aspernatur",
	                "width": 200,
	                "height": 200
	            }
            ]
        }
    ]
}
```

###Account data
The **Account** has a relationship to **Owner** so a nested data set is generated within the `owner` key for each fixture. Again we call our fixture generating utility.

```shell
composer fixture-generate
# you can use <your fixture folder>/account-data.json as a filename
```

Since valid relationships are required for proper operation, we will copy `identifier` values from the **Owner** fixture data into this fixture by hand, setting up the references as we choose. Where an identifier is required, the fake data generator shows `**REFERENCE ID REQUIRED**` instead. The end result would be a JSON file like this (we are showing only one fixture for brevity): 

```json
{
    "hbdemo.commenting.account": [
        {
            "identifier": "hbdemo.commenting.account-e7e9e6a8-2294-3aa7-a208-c0354daad87d-de_DE-9971",
            "@type": "HBDemo\\Commenting\\Account\\Model\\Aggregate\\Account",
            "revision": 54713,
            "uuid": "e7e9e6a8-2294-3aa7-a208-c0354daad87d",
            "short_id": 52893,
            "language": "de_DE",
            "version": 9971,
            "name": "Dr. Francisco Ortmann B.A.",
            "account_token": "b5893afcc870b4620ab9",
            "owner": [
                {
                    "@type": "owner",
                    "identifier": "d45ddfb3-c942-32c0-8ee8-3792ab0e2cb2",
                    "referenced_identifier": "hbdemo.commenting.owner-25e446d5-cce1-3439-b676-1650680c579d-de_DE-33697"
                }
            ]
        }
    ]
}
```

This fixture has a `owner.referenced_identifier` value from the **Owner** JSON data show earlier. Note also that this fixture does not show the mirrored value of the `name` attribute from the **Owner**. This is because the fixture is only providing data for the event store. The projections are rendered when the commands are executed and the values are reflected from the actual referenced **Owner** fixture.

###Topic data
The **Topic** contains a reference to the **Account**. Fixtures are generated as before.

```shell
composer fixture-generate
# you can use <your fixture folder>/topic-data.json as a filename
```

As before, this fixture contains an `account.referenced_identifer` value from the **Account** fixture.

```json
{
    "hbdemo.commenting.topic": [
        {
            "identifier": "hbdemo.commenting.topic-bc47bab1-c9b0-3e07-b9e9-8220ba56c0a8-de_DE-25040",
            "@type": "HBDemo\\Commenting\\Topic\\Model\\Aggregate\\Topic",
            "revision": 25482,
            "uuid": "bc47bab1-c9b0-3e07-b9e9-8220ba56c0a8",
            "short_id": 17510,
            "language": "de_DE",
            "version": 25040,
            "url": "http://www.jopich.com/qui-ducimus-et-eum-maiores-ipsam",
            "title": "Eius voluptatem earum optio explicabo nesciunt asperiores.",
            "description": "tenetur sequi eum officia qui",
            "account": [
                {
                    "@type": "account",
                    "identifier": "57f4e3e1-c17f-3ae3-839f-e9d303ec793d",
                    "referenced_identifier": "hbdemo.commenting.account-e7e9e6a8-2294-3aa7-a208-c0354daad87d-de_DE-9971"
                }
            ]
        }
    ]
}
```

Having the full entity type prefix in the `identifier` is helpful here, since we can easily see that we are specifying an entity reference of the correct type.

###Comment data
The **Comment** data requires references to **Owner** and **Topic**. We generate the fake data using the following command.

```shell
composer fixture-generate
# you can use <your fixture folder>/comment-data.json as a filename
```

In this fixture, we see two references to identifiers that can be found in the other fixtures.

```json
{
    "hbdemo.commenting.comment": [
        {
            "identifier": "hbdemo.commenting.comment-d1b7514d-ba05-31ee-b73e-19c410163f62-de_DE-85019",
            "@type": "HBDemo\\Commenting\\Comment\\Model\\Aggregate\\Comment",
            "revision": 77189,
            "uuid": "d1b7514d-ba05-31ee-b73e-19c410163f62",
            "short_id": 35720,
            "language": "de_DE",
            "version": 85019,
            "content": "Eum sequi et aut adipisci nam qui eum.",
            "topic": [
                {
                    "@type": "topic",
                    "identifier": "b8ffa625-0550-3b4e-b511-1a770576f40b",
                    "referenced_identifier": "hbdemo.commenting.topic-bc47bab1-c9b0-3e07-b9e9-8220ba56c0a8-de_DE-25040"
                }
            ],
            "owner": [
                {
                    "@type": "owner",
                    "identifier": "6140f6c7-f3cc-34e8-adf1-63887c727814",
                    "referenced_identifier": "hbdemo.commenting.owner-25e446d5-cce1-3439-b676-1650680c579d-de_DE-33697"
                }
            ]
        }
    ]
}
```

##Importing fixture data
First we need to edit our fixture class to specify the filenames of the JSON files to import. We can simply add the filenames for all our fixtures to the `getFixtureFiles` method of our class:

######fixture/20150810231335_initial_test_data/initial_test_data.php
```php
<?php

namespace HBDemo\Commenting\Fixture;

use Honeybee\Infrastructure\Fixture\Fixture;
use Honeybee\Infrastructure\Fixture\FixtureTargetInterface;

class Fixture_20150810231335_InitialTestData extends Fixture
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
            __DIR__ . DIRECTORY_SEPARATOR . 'owner-data.json',
            __DIR__ . DIRECTORY_SEPARATOR . 'account-data.json',
            __DIR__ . DIRECTORY_SEPARATOR . 'topic-data.json',
            __DIR__ . DIRECTORY_SEPARATOR . 'comment-data.json'
        ];
    }
}
```

###Preparing assets
The **Owner** has an `image-list` type attribute and the fixture data contains references to an `owner_image.png`. We provision the file by creating an `assets` folder in the fixture folder and placing a suitable file in there.

###Executing the data import
This command will prompt your for the module and fixture you would like to import. 

```shell
composer fixture-import
```

Select the fixture and a few moments later the data stores will be fully populated.

---
######Fixture creation commands
The fixture importer constructs a command for each item in the fixture data, which creates an event to be stored in the event store. The associated standard and relation projection updater are then triggered to populate the view store synchronously.

---

##Rebuilding the stores
During development if you want to rebuild your databases from scratch you can simply delete the stores, execute all migrations to reinitialise, and import your fixtures. The means you can reset your environment quickly and easily to a known state.

```shell
# this command is only available in the demo application
composer data-rebuild
```

[1]: https://github.com/honeybee/trellis
