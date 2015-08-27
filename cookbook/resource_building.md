#Resource Building
Now that all of our entity types and workflows are configured, we can generate the models and associated Elasticsearch type mappings. We use the underlying [Trellis][1] library to build our class structures. 

When your run the following command You will be prompted to choose an aggregate root type you would like to build. The utility will then ask you which migration folder you would like to store the automatically generated Elasticsearch mapping file. Pick the migration name that contains the name of the resource you are building.

```shell
# the `--all` argument builds all entity types for the selected resource
composer resource-build -- --all

Please pick an aggregate root type: 
  [0] honeybee.system_account.user
  [1] hbdemo.commenting.account
  [2] hbdemo.commenting.comment
  [3] hbdemo.commenting.owner
  [4] hbdemo.commenting.topic
> 3

# the timestamps may be different in your application
Please choose a migration in which to place generated mappings: 
  [0] 20150804155706:init_view_store
  [1] 20150804155729:create_owner_type
  [2] 20150805155352:create_account_type
  [3] 20150810181512:create_topic_type
  [4] 20150810224420:create_comment_type
  [5] none
> 1
```

This should be repeated for all of our newly configured resources with the `hbdemo.commenting` prefix. This will build all the model structures and organise them in the `app/module/HBDemo_Commenting/lib` folder.

##Elasticsearch mappings
For each resource the Elasticsearch mapping file is generated in the selected migration folder. Migration folders are located at the module level. For our new module we will be interested in the following files:

 * `migration/20150804155729_create_owner_type/owner-standard-20150804155729-mapping.json`
 * `migration/20150805155352_create_account_type/account-standard-20150805155352-mapping.json`
 * `migration/20150810181512_create_topic_type/topic-standard-20150810181512-mapping.json`
 * `migration/20150810224420_create_comment_type/comment-standard-20150810224420-mapping.json`

---
######Mapping Generator
The `MappingGeneratorPlugin` for Trellis renders a default mapping based on attributes defined in your projection type configuration. These defaults can be modified for your own purposes, or you can write your own plugin as required.

Further details on customizing Elasticsearch mappings can be found [here][2].

---

Every time a mapping is generated it is created with a new timestamp so it does not override your existing mapping. When a resource is first scaffolded a default empty mapping is generated with a creation timestamp. Every time you generate a new mapping the contents can be copied into this file so the migration class knows where to find the mapping. Alternatively you can edit the migration PHP file to specify import of the newly generated mapping file instead.

###Index settings
Index settings are defined in the `<timestamp>_init_view_store` migration folder for the module. Here you can configure Elasticsearch index wide mappings such as `number_of_shards`, `dynamic_templates` and so on.

###Owner mapping
We will review the **Owner** mapping to make sure it suits the needs of our application. We expect to search on the `name` and potentially filter by `email` and `authorization_token` so here's what it looks like.

######migration/20150804155729_create_owner_type/owner-standard-20150804155729-mapping.json
```json
{
    "properties": {
        "name": {
            "type": "string",
            "fields": {
                "sort": {
                    "type": "string",
                    "analyzer": "IcuAnalyzer_DE",
                    "include_in_all": false
                },
                "filter": {
                    "type": "string",
                    "index": "not_analyzed"
                },
                "suggest": {
                    "type": "string",
                    "analyzer": "AutoCompleteAnalyzer",
                    "include_in_all": false
                }
            }
        },
        "email": {
            "type": "string",
            "index": "not_analyzed"
        },
        "password_hash": {
            "type": "string",
            "index": "no"
        },
        "authorization_token": {
            "type": "string",
            "index": "not_analyzed"
        },
        "authorization_expires": {
            "type": "date"
        },
        "images": {
            "type": "object",
            "enabled": false
        }
    }
}
```

Text fields are automatically rendered as Elasticsearch `multi_field` which provides support for and phrase, suggestion and term filtering. The default system attributes such as `identifier` do not require a specific mapping because they are automatically mapped using `dynamic_templates` defined in the index settings. Embedded entities, lists and references are also dynamically mapped as `object` by default, although you can override these as your wish.

###Account mapping
The **Account** has a simple mapping which also contains a default `object` mapping for it's embedded **Owner** reference and mirrored attributes. You can be more explicit in the mapping if you want specific mappings for `owner.*` fields.

######migration/20150805155352_create_account_type/account-standard-20150805155352-mapping.json
```json
{
    "properties": {
        "name": {
            "type": "string",
            "fields": {
                "sort": {
                    "type": "string",
                    "analyzer": "IcuAnalyzer_DE",
                    "include_in_all": false
                },
                "filter": {
                    "type": "string",
                    "index": "not_analyzed"
                },
                "suggest": {
                    "type": "string",
                    "analyzer": "AutoCompleteAnalyzer",
                    "include_in_all": false
                }
            }
        },
        "account_token": {
            "type": "string",
            "index": "not_analyzed"
        },
        "owner": {
            "type": "object"
        }
    }
}
```

###Topic mapping
The **Topic** mapping follows the same defaults and includes an `object` type for it's embedded reference to the **Account**.

######migration/20150810181512_create_topic_type/topic-standard-20150810181512-mapping.json
```json
{
    "properties": {
        "url": {
            "type": "string",
            "index": "no"
        },
        "title": {
            "type": "string",
            "fields": {
                "sort": {
                    "type": "string",
                    "analyzer": "IcuAnalyzer_DE",
                    "include_in_all": false
                },
                "filter": {
                    "type": "string",
                    "index": "not_analyzed"
                },
                "suggest": {
                    "type": "string",
                    "analyzer": "AutoCompleteAnalyzer",
                    "include_in_all": false
                }
            }
        },
        "description": {
            "type": "string",
            "fields": {
                "sort": {
                    "type": "string",
                    "analyzer": "IcuAnalyzer_DE",
                    "include_in_all": false
                },
                "filter": {
                    "type": "string",
                    "index": "not_analyzed"
                },
                "suggest": {
                    "type": "string",
                    "analyzer": "AutoCompleteAnalyzer",
                    "include_in_all": false
                }
            }
        },
        "account": {
            "type": "object"
        }
    }
}
```

###Comment mapping
The **Comment** mapping contains a searchable `content` field with two `object` type mappings for it's reference to **Owner** and **Topic**.

######migration/20150810224420_create_comment_type/comment-standard-20150810224420-mapping.json
```json
{
    "properties": {
        "content": {
            "type": "string",
            "fields": {
                "sort": {
                    "type": "string",
                    "analyzer": "IcuAnalyzer_DE",
                    "include_in_all": false
                },
                "filter": {
                    "type": "string",
                    "index": "not_analyzed"
                },
                "suggest": {
                    "type": "string",
                    "analyzer": "AutoCompleteAnalyzer",
                    "include_in_all": false
                }
            }
        },
        "topic": {
            "type": "object"
        },
        "owner": {
            "type": "object"
        }
    }
}
```

[1]: https://github.com/honeybee/trellis
[2]: https://www.elastic.co/guide/en/elasticsearch/reference/current/mapping.html
