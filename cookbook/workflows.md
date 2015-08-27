#Workflows
Each aggregate root tyoe in the system has an associated workflow which manages its state and transitions. It is possible to fully customise the workflow configuration. We can configure the states to meet the requirements in these files:

 * `config/Owner/workflows.xml`
 * `config/Account/workflows.xml`
 * `config/Topic/workflows.xml`
 * `config/Comment/workflows.xml`

##The default workflow
The default state machine has three states: `edit`, `published` and `deleted`. It also has a special state named `edit_task` which is used by Honeybee to handle the proceeding of the workflow state back to the original state after an edit. The default workflow can be visualised as follows.

![Image of default entity workflow](https://github.com/MrHash/honeybee-agavi-cmf-demo/blob/master/cookbook/images/workflow_default.png)

##Configuring workflow states
The workflows are expected to start at an *initial* state, be *promoted* and *demoted* between intermediary states, and *deleted* to a *final* irreversible state. Each state (except the final state) allows definition of named *events* which must specify a transition *target* state which optionally may have a *guard* definition which checks if the state transition is allowed. The entities in our demo need slightly different workflows from the default. We can easily modify the default configuration to suit our needs.

Honeybee specifically uses the `promote`, `demote` and `delete` event names in order to proceed or return from states. Other custom state event names would require explicit configuration for your application.

---
######Introducing Workflux
Workflow and state management is provided by the [Workflux][1] library. This tool allows sophisticated yet easy configuration of state machines, and offers variable and expression based state transitions. Workflux is also responsible for rendering the images on the page.

---

###Owner workflow configuration 
The **Owner** has the most complicated workflow with four states, *unverified*, *verified*, *administrator*, and *deleted*. The configuraton has been modified from the default by renaming some states and introducing a new one. The state machine can be visualised as follows.

![Image of Owner entity workflow](https://github.com/MrHash/honeybee-agavi-cmf-demo/blob/master/cookbook/images/workflow_owner.png)

######config/Owner/workflows.xml
```xml
<?xml version="1.0" encoding="UTF-8" ?>
<state_machines xmlns="urn:schemas-workflux:statemachine:0.5.0">
    <state_machine name="hbdemo_commenting_owner_workflow_default">

        <initial name="unverified" class="Workflux\State\VariableState">
            <event name="edit">
                <transition target="edit_task" />
            </event>
            <event name="promote">
                <transition target="verified" />
            </event>
            <event name="delete">
                <transition target="deleted" />
            </event>
            <option name="read_only_actions">
                <option name="resource_history">
                    <option name="route">hbdemo.commenting.owner.resource.history</option>
                </option>
                <option name="view_resource">
                    <option name="route">hbdemo.commenting.owner.resource</option>
                </option>
            </option>
        </initial>

        <state name="verified" class="Workflux\State\VariableState">
            <event name="edit">
                <transition target="edit_task" />
            </event>
            <event name="demote">
                <transition target="unverified" />
            </event>
            <event name="promote">
                <transition target="administrator" />
            </event>
            <event name="delete">
                <transition target="deleted" />
            </event>
            <option name="read_only_actions">
                <option name="resource_history">
                    <option name="route">hbdemo.commenting.owner.resource.history</option>
                </option>
                <option name="view_resource">
                    <option name="route">hbdemo.commenting.owner.resource</option>
                </option>
                <option name="resource_hierarchy">
                    <option name="route">hbdemo.commenting.owner.hierarchy</option>
                </option>
            </option>
        </state>
        
        <state name="administrator" class="Workflux\State\VariableState">
            <event name="edit">
                <transition target="edit_task" />
            </event>
            <event name="demote">
                <transition target="verified" />
            </event>
            <event name="delete">
                <transition target="deleted" />
            </event>
            <option name="read_only_actions">
                <option name="resource_history">
                    <option name="route">hbdemo.commenting.owner.resource.history</option>
                </option>
                <option name="view_resource">
                    <option name="route">hbdemo.commenting.owner.resource</option>
                </option>
                <option name="resource_hierarchy">
                    <option name="route">hbdemo.commenting.owner.hierarchy</option>
                </option>
            </option>
        </state>

        <state name="edit_task" class="Workflux\State\VariableState">
            <transition target="verified">
                <guard class="Workflux\Guard\VariableGuard">
                    <option name="expression">current_state == "verified"</option>
                </guard>
            </transition>
            <transition target="unverified">
                <guard class="Workflux\Guard\VariableGuard">
                    <option name="expression">current_state == "unverified"</option>
                </guard>
            </transition>
            <transition target="administrator">
                <guard class="Workflux\Guard\VariableGuard">
                    <option name="expression">current_state == "administrator"</option>
                </guard>
            </transition>
            <option name="variables">
                <option name="task_action">
                    <option name="module">HBDemo_Commenting</option>
                    <option name="action">Owner.Resource.Modify</option>
                </option>
            </option>
        </state>

        <final name="deleted" />

    </state_machine>
</state_machines>

```

###Account workflow configuration
The **Account** workflow is simpler than the default since it only has two steady states, *active* and *deleted*.

![Image of Account entity workflow](https://github.com/MrHash/honeybee-agavi-cmf-demo/blob/master/cookbook/images/workflow_account.png)

######config/Account/workflows.xml
```xml
<?xml version="1.0" encoding="UTF-8" ?>
<state_machines xmlns="urn:schemas-workflux:statemachine:0.5.0">
    <state_machine name="hbdemo_commenting_account_workflow_default">

        <initial name="active" class="Workflux\State\VariableState">
            <event name="edit">
                <transition target="edit_task" />
            </event>
            <event name="delete">
                <transition target="deleted" />
            </event>
            <option name="read_only_actions">
                <option name="resource_history">
                    <option name="route">hbdemo.commenting.account.resource.history</option>
                </option>
                <option name="view_resource">
                    <option name="route">hbdemo.commenting.account.resource</option>
                </option>
            </option>
        </initial>

        <state name="edit_task" class="Workflux\State\VariableState">
            <transition target="active">
                <guard class="Workflux\Guard\VariableGuard">
                    <option name="expression">current_state == "active"</option>
                </guard>
            </transition>
            <option name="variables">
                <option name="task_action">
                    <option name="module">HBDemo_Commenting</option>
                    <option name="action">Account.Resource.Modify</option>
                </option>
            </option>
        </state>

        <final name="deleted" />

    </state_machine>
</state_machines>
```

###Topic workflow configuration
The **Topic** workflow is the same structure as the default except the state names have been renamed to *active*,  *frozen* and *deleted* which are more meaningful for this subject.

![Image of Topic entity workflow](https://github.com/MrHash/honeybee-agavi-cmf-demo/blob/master/cookbook/images/workflow_topic.png)

######config/Topic/workflows.xml
```xml
<?xml version="1.0" encoding="UTF-8" ?>
<state_machines xmlns="urn:schemas-workflux:statemachine:0.5.0">
    <state_machine name="hbdemo_commenting_topic_workflow_default">

        <initial name="active" class="Workflux\State\VariableState">
            <event name="edit">
                <transition target="edit_task" />
            </event>
            <event name="promote">
                <transition target="frozen" />
            </event>
            <event name="delete">
                <transition target="deleted" />
            </event>
            <option name="read_only_actions">
                <option name="resource_history">
                    <option name="route">hbdemo.commenting.topic.resource.history</option>
                </option>
                <option name="view_resource">
                    <option name="route">hbdemo.commenting.topic.resource</option>
                </option>
            </option>
        </initial>

        <state name="frozen" class="Workflux\State\VariableState">
            <event name="edit">
                <transition target="edit_task" />
            </event>
            <event name="demote">
                <transition target="active" />
            </event>
            <event name="delete">
                <transition target="deleted" />
            </event>
            <option name="read_only_actions">
                <option name="resource_history">
                    <option name="route">hbdemo.commenting.owner.resource.history</option>
                </option>
                <option name="view_resource">
                    <option name="route">hbdemo.commenting.owner.resource</option>
                </option>
                <option name="resource_hierarchy">
                    <option name="route">hbdemo.commenting.owner.hierarchy</option>
                </option>
            </option>
        </state>

        <state name="edit_task" class="Workflux\State\VariableState">
            <transition target="active">
                <guard class="Workflux\Guard\VariableGuard">
                    <option name="expression">current_state == "active"</option>
                </guard>
            </transition>
            <transition target="frozen">
                <guard class="Workflux\Guard\VariableGuard">
                    <option name="expression">current_state == "frozen"</option>
                </guard>
            </transition>
            <option name="variables">
                <option name="task_action">
                    <option name="module">HBDemo_Commenting</option>
                    <option name="action">Topic.Resource.Modify</option>
                </option>
            </option>
        </state>

        <final name="deleted" />

    </state_machine>
</state_machines>
```

###Comment workflow configuration
The **Comment** workflow is also simplified to two states, *published* and *deleted*.

![Image of Comment entity workflow](https://github.com/MrHash/honeybee-agavi-cmf-demo/blob/master/cookbook/images/workflow_comment.png)

######config/Comment/workflows.xml
```xml
<?xml version="1.0" encoding="UTF-8" ?>
<state_machines xmlns="urn:schemas-workflux:statemachine:0.5.0">
    <state_machine name="hbdemo_commenting_comment_workflow_default">

        <initial name="published" class="Workflux\State\VariableState">
            <event name="edit">
                <transition target="edit_task" />
            </event>
            <event name="delete">
                <transition target="deleted" />
            </event>
            <option name="read_only_actions">
                <option name="resource_history">
                    <option name="route">hbdemo.commenting.comment.resource.history</option>
                </option>
                <option name="view_resource">
                    <option name="route">hbdemo.commenting.comment.resource</option>
                </option>
            </option>
        </initial>

        <state name="edit_task" class="Workflux\State\VariableState">
            <transition target="published">
                <guard class="Workflux\Guard\VariableGuard">
                    <option name="expression">current_state == "published"</option>
                </guard>
            </transition>
            <option name="variables">
                <option name="task_action">
                    <option name="module">HBDemo_Commenting</option>
                    <option name="action">Comment.Resource.Modify</option>
                </option>
            </option>
        </state>

        <final name="deleted" />

    </state_machine>
</state_machines>
```

[1]: https://github.com/shrink0r/workflux
