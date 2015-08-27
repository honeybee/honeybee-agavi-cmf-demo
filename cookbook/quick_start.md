#Quick Start
Once the application is [installed](/README.md#installation) and running, you may wish to see the demo application in action. Later you can follow a more methodical approach in learning how the application is created and configured, enabling you to start implementing your own application ideas.

---
######Composer scripts
Honeybee utilities offered throughout the cookbook are executed as `composer` scripts which wrap the core utilities provided by the **Honeybee_Core** module via the `bin/cli` command.

---

###Importing data
The application can be populated with a single command to install the demo data. This is only available in the demo project.

```shell
# this command is only available in the demo application
composer data-rebuild
```

###Accessing the CMS
When you have VM running and fixture data in the system you can login and browse the demo CMS backend at:

https://honeybee-agavi-cmf-demo.local/

The demo user login name is `admin` and password is `HBAdmin1`

###Destroying data
For the purposes of the cookbook, you can reset the application back to it's initial state by executing this command to destroy all previously imported data. This command will not import any fixtures and leave the application completely empty.

```shell
# this command is only available in the demo application
composer data-destroy
```
