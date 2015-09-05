<?php
/*
 * AUTOGENERATED CODE - DO NOT EDIT!
 *
 * This base class was generated by the Trellis library and
 * must not be modified manually. Any modifications to this
 * file will be lost upon triggering the next automatic
 * class generation.
 *
 * If you are looking for a place to alter the behaviour of
 * the 'Topic' type please see the skeleton
 * class 'TopicType'. Modifications to the skeleton
 * file will prevail any subsequent class generation runs.
 *
 * To define new attributes or adjust existing attributes and their
 * default options modify the schema definition file of
 * the 'Topic' type.
 *
 * @see https://github.com/honeybee/trellis
 */

namespace HBDemo\Commenting\Topic\Projection\Standard\Base;

use Trellis\Common\Options;
use Workflux\StateMachine\StateMachineInterface;
use HBDemo\Commenting\Topic\Projection\Standard\Base;
use Honeybee\Projection\ProjectionType;

/**
 * Serves as the base class to the 'Topic' type skeleton.
 */
abstract class TopicType extends ProjectionType
{
    /**
     * StateMachineInterface $workflow_state_machine
     */
    protected $workflow_state_machine;

    /**
     * Creates a new 'TopicType' instance.
     *
     * @param StateMachineInterface $workflow_state_machine
     */
    public function __construct(StateMachineInterface $workflow_state_machine)
    {
        $this->workflow_state_machine = $workflow_state_machine;

        parent::__construct(
            'Topic',
            [
                new \Trellis\Runtime\Attribute\Url\UrlAttribute(
                    'url',
                    $this,
                    []
                ),
                new \Trellis\Runtime\Attribute\Text\TextAttribute(
                    'title',
                    $this,
                    array(
                        'max_length' => 100,
                    )
                ),
                new \Trellis\Runtime\Attribute\Text\TextAttribute(
                    'description',
                    $this,
                    []
                ),
                new \Trellis\Runtime\Attribute\EntityReferenceList\EntityReferenceListAttribute(
                    'account',
                    $this,
                    array(
                        'min_count' => 1,
                        'max_count' => 1,
                        'entity_types' => array(
                            '\\HBDemo\\Commenting\\Topic\\Projection\\Standard\\Reference\\AccountType',
                        ),
                    )
                ),
            ],
            new Options(
                array(
                'vendor' => 'HBDemo',
                'package' => 'Commenting',
                'projection' => 'Standard',
                'is_hierarchical' => false,
            )
            )
        );
    }

    /**
     * Returns an (immutable) state-machine instance responseable for controlling an entity's workflow.
     *
     * @return StateMachineInterface
     */
    public function getWorkflowStateMachine()
    {
        return $this->workflow_state_machine;
    }

    /**
     * Returns the EntityInterface implementor to use when creating new entities.
     *
     * @return string Fully qualified name of an EntityInterface implementation.
     */
    public static function getEntityImplementor()
    {
        return '\\HBDemo\\Commenting\\Topic\\Projection\\Standard\\Topic';
    }
}
