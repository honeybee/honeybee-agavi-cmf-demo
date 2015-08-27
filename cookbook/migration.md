#Migration
Migrations are used to manage the state of the data stores and data in the system. A simple and flexible migration system is provided within Honeybee project applications. 

##Listing migrations
Migrations are managed by keeping a version structure list in each data store. When executing migrations the version numbers are cross referenced so any pending migrations found in the module's `migration` folder can be executed. You can see the list of pending migrations by calling this command:

```shell
composer migration-list
```

##Executing migrations
When you are ready to execute any pending migrations you can call the following command. In our demo application we should have pending migrations relating to setting up the databases for our new resources.

```shell
# add '-- --all' arguments to execute all pending migrations
composer migration-run -- --all
```

The databases will be updated and prepared for data as required. On an initial migration for a new resource, CouchDb will be initialised with design docs and a version structure. Elasticsearch will be initialised with index settings, type mappings and a version structure.

---
######Zero Downtime
If you have a field in an index that has an Elasticsearch mapping change, it may require a full re-index. Migration commands are provided which can execute the change with zero downtime. Elasticsearch indexes are configured by default with aliases in order to support this.

---

##Making migrations
Migration folders and classes are created by default whenever you make a new module or resource. You can also create a new custom migration by calling:

```shell
composer migration-create
```

You can edit the  migration classes to suit your needs and have total control over the data stores and data.
