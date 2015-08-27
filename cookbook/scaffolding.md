#Scaffolding
In order to build an application we need to create a new module representing our domain and define the resources and entity types. Much of the configuration of the system can be done without writing code, using convenient command line tools and XML configuration.

---
######Scaffolding skeletons
The scaffolding utilities make use generic skeletons which can be defined in the `dev/skeletons` folder. It is possible to customise and create your own skeletons and generate them using the same tools.

---

##Generating modules
The module contains the scaffolding and configuration for our domain. You can scaffold a new module as follows:

```shell
composer module-create
```

You will prompted for a *vendor* name and a *package* name. These terms should uniquely represent your module. For the purpose of this demo we will use `HBDemo` as a vendor name, and `Commenting` as our package name.

##Generating resources
When a module is created it does not contain any resources so we need to create the ones we need as described in our context: **Owner**, **Account**, **Topic** and **Comment**. The resources contain the entity type definitions, models, and default configurations for interaction with your application.

For each of these we will run the following command:

```shell
composer resource-create
```

Each time you will be prompted for a module in which to create the new resource. In our case we choose `HBDemo_Commenting` as our target module.
