<?php
/**
 * Created by jbactad.
 * Date: 12/19/2016
 * Time: 4:00 PM
 */

namespace AppBundle\Entity;

interface EntityInterface
{
    /**
     * Returns the alias of the entity.
     * @return string
     */
    public static function getAlias();
}
