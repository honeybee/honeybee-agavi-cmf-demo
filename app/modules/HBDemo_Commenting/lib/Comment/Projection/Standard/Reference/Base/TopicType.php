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
 * @see https://github.com/honeybe/trellis
 */

namespace HBDemo\Commenting\Comment\Projection\Standard\Reference\Base;

use Honeybee\Projection\ReferencedEntityType;
use Trellis\Common\Options;
use Trellis\Runtime\EntityTypeInterface;
use Trellis\Runtime\Attribute\AttributeInterface;

/**
 * Serves as the base class to the 'Topic' type skeleton.
 */
abstract class TopicType extends ReferencedEntityType
{
    /**
     * Creates a new 'TopicType' instance.
     */
    public function __construct(EntityTypeInterface $parent = null, AttributeInterface $parent_attribute = null)
    {
        parent::__construct(
            'Topic',
            [
                new \Trellis\Runtime\Attribute\Text\TextAttribute(
                    'title',
                    $this,
                    array(
                        'mirrored' => true,
                    ),
                    $parent_attribute
                ),
            ],
            new Options(
                array(
                'referenced_type' => '\\HBDemo\\Commenting\\Topic\\Projection\\Standard\\TopicType',
                'identifying_attribute' => 'identifier',
            )
            ),            $parent,
            $parent_attribute
        );
    }

    /**
     * Returns the EntityInterface implementor to use when creating new entities.
     *
     * @return string Fully qualified name of an EntityInterface implementation.
     */
    public static function getEntityImplementor()
    {
        return '\\HBDemo\\Commenting\\Comment\\Projection\\Standard\\Reference\\Topic';
    }
}
