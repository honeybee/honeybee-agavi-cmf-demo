<?php

namespace HBDemo\Commenting\Comment\Model\Aggregate;

use HBDemo\Commenting\Comment\Model\Aggregate\Base\CommentType as BaseCommentType;

/**
 * Defines a set of attributes that are used to manage the comment aggregate root.
 *
 * This class reflects the declared structure of the 'Comment'
 * entity. It contains the metadata necessary to initiate and manage the
 * lifecycle of 'CommentEntity' instances. Most importantly
 * it holds a collection of attributes (and default attributes) that each of the
 * entities of this type supports.
 *
 * For more information and hooks have a look at the base classes.
 */
class CommentType extends BaseCommentType
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
