#Features

##CQRS

###Write Side

####Event Sourcing
#####Storage technology
The system events are stored by default in [CouchDb][1]. We selected this database because it is an append only, JSON document store, which promises availability. It is also a mature technology and provides sufficient performance, robust consistency and failure resilience.

Documents are stored in JSON format as data diffs with a number of additional system data fields and the database is only ever written to by the application, unless reading to replay events. Documents are never deleted.

It is possible to replace this database with the storage technology of your choice.

###Read Side
Coming soon...

####Projections
#####Storage technology
The entity projections are stored by default in [Elasticsearch][2]. 

An Elasticsearch index is created for each bounded context, although you are free to organise your indexes and types as you wish. Indicies are named with an application prefix and timestamp, and are aliased to enables support for zero down-time migrations when re-indexing is required.

It is possible to replace or augment this database with the storage technology of your choice.

##Immutability

##Modular Architecture

##Framework Bindings

##Sync & Aysnc Busses

##Processes

##Memory Management

##Internationalization (i18n)

##UI

##Tooling
###Migration
###Fixtures
Coming soon...

[1]: http://couchdb.apache.org/
[2]: https://www.elastic.co/products/elasticsearch
