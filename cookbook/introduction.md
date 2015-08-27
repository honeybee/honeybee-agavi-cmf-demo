#Introduction
This cookbook provides an example of how to to build a demo application based on a [Honeybee][1] library integration with the [Agavi][2] MVC framework.

The demonstration application is based on the domain of a simple public commenting system in the style of [Disqus][3]. The basic idea is that **Owners** will be able to create **Accounts** and add **Comments** to **Topics**.

##Demo Domain
This domain diagram describes the resources and relationships we would like to recreate in our application.

![Image of context schema](https://github.com/MrHash/honeybee-agavi-cmf-demo/blob/master/cookbook/images/context_schema.png)

As you go through the cookbook we will explain how to construct this architecture and demonstrate many capabilies of the framework.

##Honeybee Domain
The Honeybee project application comes with two built-in prerequisite modules:

 * Honeybee_Core
 * Honeybee_SystemAccount

---
######Modules as contexts
The Agavi version of the Honeybee CMF project library organises the entities and endpoints for your domain within an Agavi module. The module name is a concatenation of a vendor name and a package name which should be unique. A module is fully self contained and can be shipped as a self contained portable package.

---

###Honeybee_Core
This module contains services for various command line utilities that assist with code generation, migrations, data fixture management and more.

###Honeybee_SystemAccount
This module provides a default domain containing a single resource called **User**. This provides the basic features for handling your CMS registration, authentication, authorization and management. 


[1]: https://github.com/honeybee/honeybee
[2]: https://github.com/agavi/agavi
[3]: http://www.disqus.com
