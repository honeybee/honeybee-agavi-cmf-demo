<?php

namespace HBDemo\Commenting\Account\Model\Aggregate;

use HBDemo\Commenting\Account\Model\Aggregate\Base\AccountType as BaseAccountType;

/**
 * Defines a set of attributes that are used to manage a account aggregate-root&#039;s internal state.
 *
 * This class reflects the declared structure of the 'Account'
 * entity. It contains the metadata necessary to initiate and manage the
 * lifecycle of 'AccountEntity' instances. Most importantly
 * it holds a collection of attributes (and default attributes) that each of the
 * entities of this type supports.
 *
 * For more information and hooks have a look at the base classes.
 */
class AccountType extends BaseAccountType
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
