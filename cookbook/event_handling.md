#Event Handling
Domain events are broadcast on a domain event bus as valid commands are applied across the system. Each resource listens for relevant events that arrive on the bus, and can also be configured to listen to events that occur on other resources in order to perform related operations.

##Propogating entity changes
In our demo we would like projections to update based on changes to referenced entities. Each resource needs to be configured to listen to events occurring to related resources as follows:

 Resource  | Related Resource
---------- | ----------------
   Owner   | -
  Account  | Owner
   Topic   | Account
  Comment  | Owner & Account

The Honeybee application provides an event handler that handles projection updates for changes in related resources. For the demo application, configuration of the event handlers is done in these files:

 * `config/Account/events.xml`
 * `config/Topic/events.xml`
 * `config/Comment/events.xml`

###Owner related events
There are no related entity events that the **Owner** is interested in so we have nothing to configure.

###Account related events
The **Acount** projection has a mirrored value `name` from its related **Owner**. If the **Owner** name changes, we want the **Account** projection to be updated with the new value. Here is the contents of the configuration file.

######config/Account/events.xml
```xml
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE shortcuts [
    <!ENTITY hbdemo_commenting_account_related_entity_events
    'event.getType() matches "/^hbdemo\.commenting\.owner\..*/"'>
]>
<ae:configurations
    xmlns:ae="http://agavi.org/agavi/config/global/envelope/1.0"
    xmlns="http://berlinonline.de/schemas/honeybee/config/event_bus/1.0"
    xmlns:env="http://berlinonline.de/schemas/honeybee/config/envelope/definition/1.0"
    xmlns:xi="http://www.w3.org/2001/XInclude"
>
    <ae:configuration>
        <event_bus>
            <channels>
                <channel name="honeybee.events.domain">
                    <subscriptions>
                        <subscription enabled="true">
                            <transport>sync</transport>
                            <filter>
                                <setting name="expression">&hbdemo_commenting_account_related_entity_events;</setting>
                            </filter>
                            <handler implementor="\Honeybee\Projection\EventHandler\RelationProjectionUpdater">
                                <setting name="projection_type">hbdemo.commenting.account</setting>
                            </handler>
                        </subscription>
                    </subscriptions>
                </channel>

                <channel name="honeybee.events.replay">
                    <subscription>
                        <transport>sync</transport>
                        <filter>
                            <setting name="expression">&hbdemo_commenting_account_related_entity_events;</setting>
                        </filter>
                        <handler implementor="\Honeybee\Projection\EventHandler\RelationProjectionUpdater">
                            <setting name="projection_type">hbdemo.commenting.account</setting>
                        </handler>
                    </subscription>
                </channel>

            </channels>
        </event_bus>
    </ae:configuration>
</ae:configurations>
```

This is a standard configuration for projection relation updating. The main line of interest is:

```xml
<!ENTITY hbdemo_commenting_account_related_entity_events 
'event.getType() matches "/^hbdemo\.commenting\.owner\..*/"'>
```

In this shortcut we specify the type of the events we are interested in by specifying a regular expression. In this example we are responding to all **Owner** domain events. The provided implementor works out any changes and updates the projection with the new values. You can provide your own event handler implementation for custom event handling.

###Topic related events
The **Topic** has a similar configuration with a different shortcut name and expression:

######config/Topic/events.xml (snippet)
```xml
<!ENTITY hbdemo_commenting_topic_related_entity_events 
'event.getType() matches "/^hbdemo\.commenting\.account\..*/"'>
```

###Comment related events
The **Comment** related event listener configuration is slightly different since it is listening for events of two different types. The regular expression is easily written to enable this.

######config/Comment/events.xml (snippet)
```xml
<!ENTITY hbdemo_commenting_comment_related_entity_events 
'event.getType() matches "/^hbdemo\.commenting\.(owner|topic)\..*/"'>
```
