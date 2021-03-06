<?php

namespace HBDemo\Commenting\Account\Model\Aggregate\Reference;

use HBDemo\Commenting\Account\Model\Aggregate\Reference\Base\OwnerType as BaseOwnerType;

/**
 *
 * This class reflects the declared structure of the 'Owner'
 * entity. It contains the metadata necessary to initiate and manage the
 * lifecycle of 'OwnerEntity' instances. Most importantly
 * it holds a collection of attributes (and default attributes) that each of the
 * entities of this type supports.
 *
 * For more information and hooks have a look at the base classes.
 */
class OwnerType extends BaseOwnerType
{
    //public function getDefaultAttributes()
    //{
    //    $attributes = parent::getDefaultAttributes();
    //    $attributes['language'] = new Your\Custom\LanguageAttribute('language', array('default' => 'en_UK'));
    //    $attributes['foobar'] = new Your\Custom\FooBarAttribute('foobar');
    //    return $attributes;
    //}
    //
    //protected function getEntityImplementor()
    //{
    //    return '\\Your\\Custom\\Entity';
    //}
}
