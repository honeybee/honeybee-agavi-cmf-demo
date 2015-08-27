#Entity Configuration 
When a new resource is scaffolded, a number of XML files are generated which contain the entity type configuraton details. Inside our `HBDemo_Commenting` module we will modify the following files for each entity type according our schema design.

 * `config/Owner/entity_schema/aggregate_root.xml`
 * `config/Owner/entity_schema/projection/standard.xml`
 * `config/Account/entity_schema/aggregate_root.xml`
 * `config/Account/entity_schema/projection/standard.xml`
 * `config/Topic/entity_schema/aggregate_root.xml`
 * `config/Topic/entity_schema/projection/standard.xml`
 * `config/Comment/entity_schema/aggregate_root.xml`
 * `config/Comment/entity_schema/projection/standard.xml`

##Configuring aggregate roots and projections
The `aggregate root` defines the complete entity type structure including *attributes*, *embedded entities*, and *referenced embedded entities*. The `standard` projection entity is the default projection of the aggregate root used for default read operations.

---
######Introducing Trellis
[Trellis][1] is the name of the entity manager used by Honeybee. It provides a set of attribute data types that we can use in our entity type configurations, while also providing class generation, data validation, and fake data generation capabilities. It forms the core of entity handling in Honeybee while also being interchangable and customisable.

---

###Owner configuration
The **Owner** resource is simple with no relationships to other types. For the aggregate root type we have specified a number of attributes and their options. Each attribute has an attribute type which determines it's expected format, validation and serialization expectations.

######config/Owner/entity_schema/aggregate_root.xml
```xml
<?xml version="1.0" encoding="utf-8" ?>
<type_schema namespace="HBDemo\Commenting\Owner\Model\Aggregate"
    xmlns:xi="http://www.w3.org/2001/XInclude"
    xmlns="http://berlinonline.net/trellis/1.0/schema">
    <type_definition name="Owner">
        <implementor>\Honeybee\Model\Aggregate\AggregateRootType</implementor>
        <entity_implementor>\Honeybee\Model\Aggregate\AggregateRoot</entity_implementor>
        <description>
            Defines a set of attributes that are used to manage a owner aggregate-root's internal state.
        </description>
        <options>
            <option name="vendor">HBDemo</option>
            <option name="package">Commenting</option>
            <option name="is_hierarchical">false</option>
        </options>
        <!-- attribute definitions -->
        <attributes>
            <!-- This attribute is a string with options for min and max length -->
            <attribute name="name" type="text">
                <option name="min_length">1</option>
                <option name="max_length">100</option>
            </attribute>

            <!-- A valid email address -->
            <attribute name="email" type="email" />

            <!-- A string to contain a password hash with a fixed length -->
            <attribute name="password_hash" type="text">
                <option name="min_length">60</option>
                <option name="max_length">60</option>
            </attribute>

            <!-- A token string of fixed length containing characters in the class [a-f0-9],
                 automatically generated if not provided -->
            <attribute name="authorization_token" type="token">
                <option name="min_length">20</option>
                <option name="max_length">20</option>
                <option name="default_value">auto_gen</option>
            </attribute>

            <!-- A full PHP native DateTime value rendered to ISO8601 format,
                 including microseconds when serialized -->
            <attribute name="authorization_expires" type="timestamp" />
            
            <!-- A list of images with associated metadata -->
            <attribute name="images" type="image-list" />
        </attributes>
    </type_definition>
</type_schema>

```

The default `standard` projection type configuration includes the attributes from the aggregate root type configuration, so we have nothing to add to the default for this projection.

######config/Owner/entity_schema/projection/standard.xml
```xml
<?xml version="1.0" encoding="utf-8" ?>
<type_schema namespace="HBDemo\Commenting\Owner\Projection\Standard"
    xmlns:xi="http://www.w3.org/2001/XInclude"
    xmlns="http://berlinonline.net/trellis/1.0/schema">
    <type_definition name="Owner">
        <implementor>\Honeybee\Projection\ProjectionType</implementor>
        <entity_implementor>\Honeybee\Projection\Projection</entity_implementor>
        <description>
            Defines the (normalized) strucuture of a default owner projection.
        </description>
        <options>
            <option name="vendor">HBDemo</option>
            <option name="package">Commenting</option>
            <option name="is_hierarchical">false</option>
        </options>
        <!-- attribute definitions -->
        <xi:include href="../aggregate_root.xml" xpointer="xmlns(dt=http://berlinonline.net/trellis/1.0/schema)
            xpointer(/dt:type_schema/dt:type_definition/dt:attributes)">
        </xi:include>
    </type_definition>
</type_schema>

```

---
######Default Entity Attributes
Each entity in the system has default attributes which are required in order for them to function correctly in the system. They are as follows:

 * **@type**: the *FQCN* of the current entity type
 * **identifier**: system generated string of format: `type_prefix-uuid-language-version`
 * **revision**: integer representing the revision of the document
 * **uuid**: uuidv4 string
 * **short_id**: (optional) integer representing a convenience id
 * **language**: locale string
 * **version**: integer representing the version of the document
 * **created_at**: ISO8601 creation timestamp
 * **modified_at**: ISO8601 modification timestamp
 * **workflow_state**: string containing the initial workflow state for the entity
 * **workflow_parameters**: array containing the parameters for the entity workflow

---

###Account configuration
The **Account** is expected to have a **n:1** relationship to **Owner**. Here we introduce a new attribute type named `entity-reference-list`. This is a collection object which contains references to entities as specified in the `entity_types` option. The definition for the referenced entity types appear below in the `reference_definitions` section.

######config/Account/entity_schema/aggregate_root.xml
```xml
<?xml version="1.0" encoding="utf-8" ?>
<type_schema namespace="HBDemo\Commenting\Account\Model\Aggregate"
    xmlns:xi="http://www.w3.org/2001/XInclude"
    xmlns="http://berlinonline.net/trellis/1.0/schema">
    <type_definition name="Account">
        <implementor>\Honeybee\Model\Aggregate\AggregateRootType</implementor>
        <entity_implementor>\Honeybee\Model\Aggregate\AggregateRoot</entity_implementor>
        <description>
            Defines a set of attributes that are used to manage a account aggregate-root's internal state.
        </description>
        <options>
            <option name="vendor">HBDemo</option>
            <option name="package">Commenting</option>
            <option name="is_hierarchical">false</option>
        </options>
        <!-- attribute definitions -->
        <attributes>
            <attribute name="name" type="text">
                <option name="min_length">1</option>
                <option name="max_length">100</option>
            </attribute>
            
            <attribute name="account_token" type="token">
                <option name="min_length">20</option>
                <option name="max_length">20</option>
                <option name="default_value">auto_gen</option>
            </attribute>
            
            <!-- This is a collection of entity references, which can be of mixed types,
                 specified in the 'entity_types' option -->
            <attribute name="owner" type="entity-reference-list">
                <option name="min_count">1</option>
                <option name="max_count">1</option>
                <option name="entity_types">
                    <option>Owner</option>
                </option>
            </attribute>
        </attributes>
    </type_definition>
    
    <reference_definitions>
        <!-- This reference definition defines the reference expected in the 'owner' attribute -->
        <reference_definition name="Owner">
            <implementor>\Honeybee\Model\Aggregate\ReferencedEntityType</implementor>
            <entity_implementor>\Honeybee\Model\Aggregate\ReferencedEntity</entity_implementor>
            <option name="referenced_type">\HBDemo\Commenting\Owner\Model\Aggregate\OwnerType</option>
            <option name="identifying_attribute">identifier</option>
        </reference_definition>
    </reference_definitions>
</type_schema>
```

The `standard` projection includes the attributes from the aggregate root type, so we must also provide a reference definition for the projection. In this example the projection is configured to mirror the value of `name` from the referenced  **Owner** entity to the **Account** document when stored. This enables searching by referenced entity values and for displaying human readable information while keeping all required data in a single document without the need for joining.

######config/Account/entity_schema/projection/standard.xml
```xml
<?xml version="1.0" encoding="utf-8" ?>
<type_schema namespace="HBDemo\Commenting\Account\Projection\Standard"
    xmlns:xi="http://www.w3.org/2001/XInclude"
    xmlns="http://berlinonline.net/trellis/1.0/schema">
    <type_definition name="Account">
        <implementor>\Honeybee\Projection\ProjectionType</implementor>
        <entity_implementor>\Honeybee\Projection\Projection</entity_implementor>
        <description>
            Defines the (normalized) strucuture of a default account projection.
        </description>
        <options>
            <option name="vendor">HBDemo</option>
            <option name="package">Commenting</option>
            <option name="is_hierarchical">false</option>
        </options>
        <!-- attribute definitions -->
        <xi:include href="../aggregate_root.xml" xpointer="xmlns(dt=http://berlinonline.net/trellis/1.0/schema)
            xpointer(/dt:type_schema/dt:type_definition/dt:attributes)">
        </xi:include>
    </type_definition>
    
    <reference_definitions>
        <reference_definition name="Owner">
            <implementor>\Honeybee\Projection\ReferencedEntityType</implementor>
            <entity_implementor>\Honeybee\Projection\ReferencedEntity</entity_implementor>
            <option name="referenced_type">\HBDemo\Commenting\Owner\Projection\Standard\OwnerType</option>
            <option name="identifying_attribute">identifier</option>
            <!-- referenced attribute definitions -->
            <attributes>
                <attribute name="name" type="text">
                    <option name="mirrored">true</option>
                </attribute>
            </attributes>
        </reference_definition>
    </reference_definitions>
</type_schema>

```

---
######Consistency of mirrored values
Mirrored values in projections are kept up to date simply by configuring a resource event handler to listen to modification events on the related resources event channels. This is explained in more detail in the section on [Events][2]

---

###Topic configuration
The **Topic** has an **n:1** relationship to an **Account**. The configuration is similar to the **Account** entity types.

######config/Topic/entity_schema/aggregate_root.xml
```xml
<?xml version="1.0" encoding="utf-8" ?>
<type_schema namespace="HBDemo\Commenting\Topic\Model\Aggregate"
    xmlns:xi="http://www.w3.org/2001/XInclude"
    xmlns="http://berlinonline.net/trellis/1.0/schema">
    <type_definition name="Topic">
        <implementor>\Honeybee\Model\Aggregate\AggregateRootType</implementor>
        <entity_implementor>\Honeybee\Model\Aggregate\AggregateRoot</entity_implementor>
        <description>
            Defines a set of attributes that are used to manage the topic aggregate root.
        </description>
        <options>
            <option name="vendor">HBDemo</option>
            <option name="package">Commenting</option>
            <option name="is_hierarchical">false</option>
        </options>
        <!-- attribute definitions -->
        <attributes>
            <!-- the url type is a string validated according to rfc2396 -->
            <attribute name="url" type="url" />
            
            <!-- the topic title with a length constraint -->
            <attribute name="title" type="text">
                <option name="max_length">100</option>
            </attribute>
            
            <!-- a string of any length -->
            <attribute name="description" type="text" />
            
            <!-- This is a collection of entity references, which can be of mixed types,
                 specified in the 'entity_types' option -->
            <attribute name="account" type="entity-reference-list">
                <option name="min_count">1</option>
                <option name="max_count">1</option>
                <option name="entity_types">
                    <option>Account</option>
                </option>
            </attribute>
        </attributes>
    </type_definition>
    
    <reference_definitions>
        <!-- This reference definition defines the reference expected in the 'account' attribute -->
        <reference_definition name="Account">
            <implementor>\Honeybee\Model\Aggregate\ReferencedEntityType</implementor>
            <entity_implementor>\Honeybee\Model\Aggregate\ReferencedEntity</entity_implementor>
            <option name="referenced_type">\Honeybee\SystemAccount\Account\Model\Aggregate\AccountType</option>
            <option name="identifying_attribute">identifier</option>
        </reference_definition>
    </reference_definitions>
</type_schema>

```

The `standard` projection type for the **Topic** includes a mirrored value from the referenced **Account** entity.

######config/Topic/entity_schema/projection/standard.xml
```xml
<?xml version="1.0" encoding="utf-8" ?>
<type_schema namespace="HBDemo\Commenting\Topic\Projection\Standard"
    xmlns:xi="http://www.w3.org/2001/XInclude"
    xmlns="http://berlinonline.net/trellis/1.0/schema">
    <type_definition name="Topic">
        <implementor>\Honeybee\Projection\ProjectionType</implementor>
        <entity_implementor>\Honeybee\Projection\Projection</entity_implementor>
        <description>
            Defines the (normalized) strucuture of the standard topic projection.
        </description>
        <options>
            <option name="vendor">HBDemo</option>
            <option name="package">Commenting</option>
            <option name="is_hierarchical">false</option>
        </options>
        <!-- attribute definitions -->
        <xi:include href="../aggregate_root.xml" xpointer="xmlns(dt=http://berlinonline.net/trellis/1.0/schema)
            xpointer(/dt:type_schema/dt:type_definition/dt:attributes)">
        </xi:include>
    </type_definition>
    
    <reference_definitions>
        <reference_definition name="Account">
            <implementor>\Honeybee\Projection\ReferencedEntityType</implementor>
            <entity_implementor>\Honeybee\Projection\ReferencedEntity</entity_implementor>
            <option name="referenced_type">\HBDemo\Commenting\Account\Projection\Standard\AccountType</option>
            <option name="identifying_attribute">identifier</option>
            <!-- referenced attribute definitions -->
            <attributes>
                <attribute name="name" type="text">
                    <option name="mirrored">true</option>
                </attribute>
            </attributes>
        </reference_definition>
    </reference_definitions>
</type_schema>

```

###Comment entity configuration
The **Comment** has a **n:1** realtionship with both **Owner** (the person who created the comment) and **Topic** (the topic the comment refers to). The configuration of the aggregate root type extends the concept introduced earlier.

######config/Comment/entity_schema/aggregate_root.xml
```xml
<?xml version="1.0" encoding="utf-8" ?>
<type_schema namespace="HBDemo\Commenting\Comment\Model\Aggregate"
    xmlns:xi="http://www.w3.org/2001/XInclude"
    xmlns="http://berlinonline.net/trellis/1.0/schema">
    <type_definition name="Comment">
        <implementor>\Honeybee\Model\Aggregate\AggregateRootType</implementor>
        <entity_implementor>\Honeybee\Model\Aggregate\AggregateRoot</entity_implementor>
        <description>
            Defines a set of attributes that are used to manage the comment aggregate root.
        </description>
        <options>
            <option name="vendor">HBDemo</option>
            <option name="package">Commenting</option>
            <option name="is_hierarchical">false</option>
        </options>
        <!-- attribute definitions -->
        <attributes>
            <!-- a string of any length -->
            <attribute name="content" type="text" />
            
            <!-- The collection containing the reference to the Topic -->
            <attribute name="topic" type="entity-reference-list">
                <option name="min_count">1</option>
                <option name="max_count">1</option>
                <option name="entity_types">
                    <option>Topic</option>
                </option>
            </attribute>
            
            <!-- The collection containing the reference to the Owner -->
            <attribute name="owner" type="entity-reference-list">
                <option name="min_count">1</option>
                <option name="max_count">1</option>
                <option name="entity_types">
                    <option>Owner</option>
                </option>
            </attribute>
        </attributes>
    </type_definition>
    
    <reference_definitions>
        <reference_definition name="Topic">
            <implementor>\Honeybee\Model\Aggregate\ReferencedEntityType</implementor>
            <entity_implementor>\Honeybee\Model\Aggregate\ReferencedEntity</entity_implementor>
            <option name="referenced_type">\HBDemo\Commenting\Topic\Model\Aggregate\TopicType</option>
            <option name="identifying_attribute">identifier</option>
        </reference_definition>
        
        <reference_definition name="Owner">
            <implementor>\Honeybee\Model\Aggregate\ReferencedEntityType</implementor>
            <entity_implementor>\Honeybee\Model\Aggregate\ReferencedEntity</entity_implementor>
            <option name="referenced_type">\HBDemo\Commenting\Owner\Model\Aggregate\OwnerType</option>
            <option name="identifying_attribute">identifier</option>
        </reference_definition>
    </reference_definitions>
</type_schema>
```

The `standard` projection also extends the same configuration concept where we mirror useful values into our **Comment** document.

######config/Comment/entity_schema/projection/standard.xml
```xml
<?xml version="1.0" encoding="utf-8" ?>
<type_schema namespace="HBDemo\Commenting\Comment\Projection\Standard"
    xmlns:xi="http://www.w3.org/2001/XInclude"
    xmlns="http://berlinonline.net/trellis/1.0/schema">
    <type_definition name="Comment">
        <implementor>\Honeybee\Projection\ProjectionType</implementor>
        <entity_implementor>\Honeybee\Projection\Projection</entity_implementor>
        <description>
            Defines the (normalized) strucuture of the standard comment projection.
        </description>
        <options>
            <option name="vendor">HBDemo</option>
            <option name="package">Commenting</option>
            <option name="is_hierarchical">false</option>
        </options>
        <!-- attribute definitions -->
        <xi:include href="../aggregate_root.xml" xpointer="xmlns(dt=http://berlinonline.net/trellis/1.0/schema)
            xpointer(/dt:type_schema/dt:type_definition/dt:attributes)">
        </xi:include>
    </type_definition>
    
    <reference_definitions>
        <reference_definition name="Topic">
            <implementor>\Honeybee\Projection\ReferencedEntityType</implementor>
            <entity_implementor>\Honeybee\Projection\ReferencedEntity</entity_implementor>
            <option name="referenced_type">\HBDemo\Commenting\Topic\Projection\Standard\TopicType</option>
            <option name="identifying_attribute">identifier</option>
            <attributes>
                <attribute name="title" type="text">
                    <option name="mirrored">true</option>
                </attribute>
            </attributes>
        </reference_definition>
        
        <reference_definition name="Owner">
            <implementor>\Honeybee\Projection\ReferencedEntityType</implementor>
            <entity_implementor>\Honeybee\Projection\ReferencedEntity</entity_implementor>
            <option name="referenced_type">\HBDemo\Commenting\Owner\Projection\Standard\OwnerType</option>
            <option name="identifying_attribute">identifier</option>
            <attributes>
                <attribute name="name" type="text">
                    <option name="mirrored">true</option>
                </attribute>
            </attributes>
        </reference_definition>
    </reference_definitions>
</type_schema>
```

All the entity types and relationships in our system are now modelled according to our initial schema design.

[1]: https://github.com/honeybee/trellis
[2]: ./events.md
