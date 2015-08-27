#Templating
The administration interface can be easily configured to show data from our resources and provide input forms for creating or modifying data. The files we are interested in configuring are as follows:

 * `impl/Owner/Collection/Collection.view_templates.xml`
 * `impl/Owner/Resource/Modify/Modify.view_templates.xml`
 * `impl/Account/Collection/Collection.view_templates.xml`
 * `impl/Account/Resource/Modify/Modify.view_templates.xml`
 * `impl/Account/Resource/Modify/Modify.view_configs.xml`
 * `impl/Topic/Collection/Collection.view_templates.xml`
 * `impl/Topic/Resource/Modify/Modify.view_templates.xml`
 * `impl/Topic/Resource/Modify/Modify.view_configs.xml`
 * `impl/Comment/Collection/Collection.view_templates.xml`
 * `impl/Comment/Resource/Modify/Modify.view_templates.xml`
 * `impl/Comment/Resource/Modify/Modify.view_configs.xml`
 
##Owner templating
The default collection view only shows system attributes. We can add something more useful by configuring the collection view template as follows:

######impl/Owner/Collection/Collection.view_templates.xml
```xml
<?xml version="1.0" encoding="UTF-8"?>
<ae:configurations
    xmlns:ae="http://agavi.org/agavi/config/global/envelope/1.0"
    xmlns="http://berlinonline.de/schemas/honeybee/config/view_templates/1.0"
    xmlns:env="http://berlinonline.de/schemas/honeybee/config/envelope/definition/1.0"
    xmlns:xi="http://www.w3.org/2001/XInclude"
>
    <ae:configuration>
        <view_templates scope="hbdemo.commenting.owner.collection">
            <view_template name="hbdemo.commenting.owner">
                <tab name="owners">
                    <panel name="main">
                        <row>
                            <cell>
                                <group name="user">
                                    <field name="name" attribute_path="name" />
                                    
                                    <field name="modified_at" attribute_path="modified_at" />
                                    
                                    <field name="workflow_state" attribute_path="workflow_state" />
                                </group>
                            </cell>
                        </row>
                    </panel>
                </tab>
            </view_template>
        </view_templates>
    </ae:configuration>
</ae:configurations>
```
 
Here we have simply added the `name` field and removed the default `identifier` and `created_at` fields from the view. The `name` attribute provides a translation key while the `attribute_path` is the path to the value holder for this attribute. This change can be seen at https://honeybee-agavi-cmf-demo.local/hbdemo-commenting-owner/collection.

---
######Translation & i18n
Fields that are added for display are always translatable using the `name` attribute on the field. The translation keys can be specified for activities, fields and all display elements and are found in the `translation.xml` file for each type.

---

We can modify the default resource creation and modification input form in the same place since they share a template configuration. In other words, by default a modify action can use the same form as a creation action.

######impl/Owner/Resource/Modify/Modify.view_templates.xml
```xml
<?xml version="1.0" encoding="UTF-8"?>
<ae:configurations
    xmlns:ae="http://agavi.org/agavi/config/global/envelope/1.0"
    xmlns="http://berlinonline.de/schemas/honeybee/config/view_templates/1.0"
    xmlns:env="http://berlinonline.de/schemas/honeybee/config/envelope/definition/1.0"
    xmlns:xi="http://www.w3.org/2001/XInclude"
>
    <ae:configuration>
        <view_templates scope="hbdemo.commenting.owner.resource.modify">
            <view_template name="hbdemo.commenting.owner">
                <tab name="content">
                    <panel name="main">
                        <row>
                            <cell>
                                <group name="primary">
                                    <field name="identifier" attribute_path="identifier" template="html/attribute/as_input_text.twig">
                                        <setting name="readonly">true</setting>
                                    </field>
                                    
                                    <field name="revision" attribute_path="revision" template="html/attribute/as_input_text.twig">
                                        <setting name="readonly">true</setting>
                                    </field>
                                    
                                    <field name="name" attribute_path="name" template="html/attribute/as_input_text.twig" />
                                    
                                    <field name="email" attribute_path="email" template="html/attribute/as_input_text.twig" />
                                    
                                    <field name="images" attribute_path="images" template="html/attribute/image-list/as_tabs.twig">
                                        <setting name="use_converjon">true</setting>
                                    </field>
                                </group>
                            </cell>
                        </row>
                    </panel>
                </tab>
            </view_template>
        </view_templates>
    </ae:configuration>
</ae:configurations>
```

Note here that we have added some fields to the form using a default template for the field which renders the value into an input text field. We have also included the `identifier` and `revision` system attributes as `readonly` fields for display purposes. The `images` field displays an image list handling block in the form, which uses `converjon` for thumbnailing.

You can now see the resource creation form at https://honeybee-agavi-cmf-demo.local/hbdemo-commenting-owner/create and you can look at one of the fixture [here][1], or create your own entry and then edit it.

---
######Required fields
When creating a template which is used to create or modify resources, the `identifier` and `revision` are required fields. For embedded entity templates the `referenced_identifier` is also required. These fields can be configured to use the `html/attribute/as_input_hidden.twig` template attribute if they should be hidden.

---

##Account templating
The templating for the **Account** is a little more complicated because it requires a reference to an **Owner** . So we need to be able to attach an owner to an account easily. In order to do this we need to setup the templates in a certain way which looks like this:

######impl/Account/Collection/Collection.view_templates.xml
```xml
<?xml version="1.0" encoding="UTF-8"?>
<ae:configurations
    xmlns:ae="http://agavi.org/agavi/config/global/envelope/1.0"
    xmlns="http://berlinonline.de/schemas/honeybee/config/view_templates/1.0"
    xmlns:env="http://berlinonline.de/schemas/honeybee/config/envelope/definition/1.0"
    xmlns:xi="http://www.w3.org/2001/XInclude"
>
    <ae:configuration>
        <view_templates scope="hbdemo.commenting.account.collection">
            <view_template name="hbdemo.commenting.account">
                <tab name="accounts">
                    <panel name="main">
                        <row>
                            <cell>
                                <group name="user">
                                    <field name="name" attribute_path="name" />
                                    
                                    <field name="owner" attribute_path="owner.owner.name" attribute_value_path="owner.owner[0].name" />
                                    
                                    <field name="modified_at" attribute_path="modified_at" />
                                    
                                    <field name="workflow_state" attribute_path="workflow_state" />
                                </group>
                            </cell>
                        </row>
                    </panel>
                </tab>
            </view_template>
        </view_templates>
    </ae:configuration>
</ae:configurations>
```
Notice how we have an `owner` field which provides an `attribute_path` which has a dot notation value. The path represents the `<account 'owner' collection>.<owner entity type>.<owner attribute 'name'>`. The `attribute_value_path` represents the actual value to display since there could be multiple entities of different types in a collection. In this example we show the `name` attribute value from the first owner in the collection at key 0.

Now when you look at the collection listing at https://honeybee-agavi-cmf-demo.local/hbdemo-commenting-owner/collection you should see the owner name alongside the account name.

Creating the forms templates is a little more complex as it requires defining a new template for the embedded entity and assigning a renderer configuration to it. Here is the view template:

######impl/Account/Resource/Modify/Modify.view_templates.xml
```xml
<?xml version="1.0" encoding="UTF-8"?>
<ae:configurations
    xmlns:ae="http://agavi.org/agavi/config/global/envelope/1.0"
    xmlns="http://berlinonline.de/schemas/honeybee/config/view_templates/1.0"
    xmlns:env="http://berlinonline.de/schemas/honeybee/config/envelope/definition/1.0"
    xmlns:xi="http://www.w3.org/2001/XInclude"
>
    <ae:configuration>
        <view_templates scope="hbdemo.commenting.account.resource.modify">
            <view_template name="hbdemo.commenting.account">
                <tab name="content">
                    <panel name="main">
                        <row>
                            <cell>
                                <group name="primary">
                                    <field name="identifier" attribute_path="identifier" template="html/attribute/as_input_text.twig">
                                        <setting name="readonly">true</setting>
                                    </field>
                                    
                                    <field name="revision" attribute_path="revision" template="html/attribute/as_input_text.twig">
                                        <setting name="readonly">true</setting>
                                    </field>
                                    
                                    <field name="name" attribute_path="name" template="html/attribute/as_input_text.twig" />
                                    
                                    <field name="owner" attribute_path="owner">
                                        <setting name="owner.suggest_attribute">name</setting>
                                        <setting name="hide_entity_list">true</setting>
                                    </field>
                                </group>
                            </cell>
                        </row>
                    </panel>
                </tab>
            </view_template>
            
            <view_template name="hbdemo.commenting.account.owner.owner">
                <tab name="content">
                    <panel name="main">
                        <row>
                            <cell>
                                <group name="primary">
                                    <field name="identifier" attribute_path="identifier" template="html/attribute/as_input_hidden.twig" />
                                    <field name="referenced_identifier" attribute_path="referenced_identifier" template="html/attribute/as_input_hidden.twig" />
                                    <field name="name" attribute_path="name" template="html/attribute/as_input_text.twig" />
                                </group>
                            </cell>
                        </row>
                    </panel>
                </tab>
            </view_template>
        </view_templates>
    </ae:configuration>
</ae:configurations>
```

Here you can see the owner field is added to the main form, with an additional setting `owner.suggest_attribute` which tells the finder which field to search on. Since we want to attach owners to accounts by name this makes sense. We have also added a new view template which defines how the embedded owner will be displayed in the form. The `identifier` and `referenced_identifier` are included but hidden so that when the form is posted we can validate the association.

######impl/Account/Resource/Modify/Modify.view_configs.xml
```xml
<?xml version="1.0" encoding="UTF-8"?>
<ae:configurations
    xmlns="http://berlinonline.de/schemas/honeybee/config/view_configs/1.0"
    xmlns:env="http://berlinonline.de/schemas/honeybee/config/envelope/definition/1.0"
    xmlns:ae="http://agavi.org/agavi/config/global/envelope/1.0"
    xmlns:xi="http://www.w3.org/2001/XInclude"
>
    <ae:configuration>
        <view_configs>
            <view_config scope="hbdemo.commenting.account.resource.modify">
                <output_formats>
                    <output_format name="html">
                        <renderer_configs>
                            <renderer_config subject="hbdemo.commenting.account">
                                <settings>
                                    <setting name="template">html/resource/as_fields_with_viewtemplate.twig</setting>
                                </settings>
                            </renderer_config>
                            
                            <renderer_config subject="primary_activities">
                                <settings>
                                    <setting name="default_activity_name">save_resource</setting>
                                    <setting name="as_list">true</setting>
                                </settings>
                            </renderer_config>
                            
                            <renderer_config subject="activity.save_resource">
                                <settings>
                                    <setting name="template">html/activity/as_submit.twig</setting>
                                </settings>
                            </renderer_config>
                            
                            <renderer_config subject="hbdemo.commenting.account.owner.owner">
                                <settings>
                                    <setting name="css">sheet</setting>
                                    <setting name="template">html/embedded_entity/as_fields_with_viewtemplate_without_tabs.twig</setting>
                                </settings>
                            </renderer_config>
                        </renderer_configs>
                    </output_format>
                </output_formats>
            </view_config>
        </view_configs>
    </ae:configuration>
</ae:configurations>
```

A `renderer_config` is added to the default configuration so the renderer knows to render the `owner` attribute differently as an embedded resource.

##Topic templating
The templating for the **Topic** is similar to the **Account**. We do not show the code here for brevity. The relevant filenames are as follows.

 * `impl/Topic/Collection/Collection.view_templates.xml`
 * `impl/Topic/Resource/Modify/Modify.view_templates.xml`
 * `impl/Topic/Resource/Modify/Modify.view_configs.xml`

##Comment Templating
Templating for the **Comment** requires references to **Owner** and **Topic**. The configuration follows the same pattern as before.

######impl/Comment/Collection/Collection.view_templates.xml
```xml
<?xml version="1.0" encoding="UTF-8"?>
<ae:configurations
    xmlns:ae="http://agavi.org/agavi/config/global/envelope/1.0"
    xmlns="http://berlinonline.de/schemas/honeybee/config/view_templates/1.0"
    xmlns:env="http://berlinonline.de/schemas/honeybee/config/envelope/definition/1.0"
    xmlns:xi="http://www.w3.org/2001/XInclude"
>
    <ae:configuration>
        <view_templates scope="hbdemo.commenting.comment.collection">
            <view_template name="hbdemo.commenting.comment">
                <tab name="comments">
                    <panel name="main">
                        <row>
                            <cell>
                                <group name="user">
                                    <field name="owner" attribute_path="owner.owner.name" attribute_value_path="owner.owner[0].name" />
                                    
                                    <field name="topic" attribute_path="topic.topic.title" attribute_value_path="topic.topic[0].title" />
                                    
                                    <field name="content" attribute_path="content" />
                                    
                                    <field name="modified_at" attribute_path="modified_at" />
                                    
                                    <field name="workflow_state" attribute_path="workflow_state" />
                                </group>
                            </cell>
                        </row>
                    </panel>
                </tab>
            </view_template>
        </view_templates>
    </ae:configuration>
</ae:configurations>
```

In the collection view we show the name of the owner and the title of the topic the comment belongs to.

######impl/Comment/Resource/Modify/Modify.view_templates.xml
```xml
<?xml version="1.0" encoding="UTF-8"?>
<ae:configurations
    xmlns:ae="http://agavi.org/agavi/config/global/envelope/1.0"
    xmlns="http://berlinonline.de/schemas/honeybee/config/view_templates/1.0"
    xmlns:env="http://berlinonline.de/schemas/honeybee/config/envelope/definition/1.0"
    xmlns:xi="http://www.w3.org/2001/XInclude"
>
    <ae:configuration>
        <view_templates scope="hbdemo.commenting.comment.resource.modify">
            <view_template name="hbdemo.commenting.comment">
                <tab name="content">
                    <panel name="main">
                        <row>
                            <cell>
                                <group name="primary">
                                    <field name="identifier" attribute_path="identifier" template="html/attribute/as_input_text.twig">
                                        <setting name="readonly">true</setting>
                                    </field>
                                    
                                    <field name="revision" attribute_path="revision" template="html/attribute/as_input_text.twig">
                                        <setting name="readonly">true</setting>
                                    </field>
                                    
                                    <field name="content" attribute_path="content" template="html/attribute/as_input_text.twig" />
                                    
                                    <field name="topic" attribute_path="topic">
                                        <setting name="topic.suggest_attribute">title</setting>
                                        <setting name="hide_entity_list">true</setting>
                                    </field>
                                    
                                    <field name="owner" attribute_path="owner">
                                        <setting name="owner.suggest_attribute">name</setting>
                                        <setting name="hide_entity_list">true</setting>
                                    </field>
                                </group>
                            </cell>
                        </row>
                    </panel>
                </tab>
            </view_template>
            
            <view_template name="hbdemo.commenting.comment.topic.topic">
                <tab name="content">
                    <panel name="main">
                        <row>
                            <cell>
                                <group name="primary">
                                    <field name="identifier" attribute_path="identifier" template="html/attribute/as_input_hidden.twig" />
                                    <field name="referenced_identifier" attribute_path="referenced_identifier" template="html/attribute/as_input_hidden.twig" />
                                    <field name="title" attribute_path="title" template="html/attribute/as_input_text.twig" />
                                </group>
                            </cell>
                        </row>
                    </panel>
                </tab>
            </view_template>
            
            <view_template name="hbdemo.commenting.comment.owner.owner">
                <tab name="content">
                    <panel name="main">
                        <row>
                            <cell>
                                <group name="primary">
                                    <field name="identifier" attribute_path="identifier" template="html/attribute/as_input_hidden.twig" />
                                    <field name="referenced_identifier" attribute_path="referenced_identifier" template="html/attribute/as_input_hidden.twig" />
                                    <field name="name" attribute_path="name" template="html/attribute/as_input_text.twig" />
                                </group>
                            </cell>
                        </row>
                    </panel>
                </tab>
            </view_template>
        </view_templates>
    </ae:configuration>
</ae:configurations>
```

In this view template we add attributes for referencing both the **Topic** and **Owner**, and their associated template configuration blocks.

######impl/Comment/Resource/Modify/Modify.view_configs.xml
```xml
<?xml version="1.0" encoding="UTF-8"?>
<ae:configurations
    xmlns="http://berlinonline.de/schemas/honeybee/config/view_configs/1.0"
    xmlns:env="http://berlinonline.de/schemas/honeybee/config/envelope/definition/1.0"
    xmlns:ae="http://agavi.org/agavi/config/global/envelope/1.0"
    xmlns:xi="http://www.w3.org/2001/XInclude"
>
    <ae:configuration>
        <view_configs>
            <view_config scope="hbdemo.commenting.comment.resource.modify">
                <output_formats>
                    <output_format name="html">
                        <renderer_configs>
                            <renderer_config subject="hbdemo.commenting.comment">
                                <settings>
                                    <setting name="template">html/resource/as_fields_with_viewtemplate.twig</setting>
                                </settings>
                            </renderer_config>
                            
                            <renderer_config subject="primary_activities">
                                <settings>
                                    <setting name="default_activity_name">save_resource</setting>
                                    <setting name="as_list">true</setting>
                                </settings>
                            </renderer_config>
                            
                            <renderer_config subject="activity.save_resource">
                                <settings>
                                    <setting name="template">html/activity/as_submit.twig</setting>
                                </settings>
                            </renderer_config>
                            
                            <renderer_config subject="hbdemo.commenting.comment.topic.topic">
                                <settings>
                                    <setting name="css">sheet</setting>
                                    <setting name="template">html/embedded_entity/as_fields_with_viewtemplate_without_tabs.twig</setting>
                                </settings>
                            </renderer_config>
                            
                            <renderer_config subject="hbdemo.commenting.comment.owner.owner">
                                <settings>
                                    <setting name="css">sheet</setting>
                                    <setting name="template">html/embedded_entity/as_fields_with_viewtemplate_without_tabs.twig</setting>
                                </settings>
                            </renderer_config>
                        </renderer_configs>
                    </output_format>
                </output_formats>
            </view_config>
        </view_configs>
    </ae:configuration>
</ae:configurations>
```

Finally we add the resource renderers in the same way as before.

[1]: https://honeybee-agavi-cmf-demo.local/en_GB/hbdemo-commenting-owner/hbdemo.commenting.owner-25e446d5-cce1-3439-b676-1650680c579d-de_DE-33697/tasks/edit
