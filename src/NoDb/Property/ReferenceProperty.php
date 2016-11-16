<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 14.11.16
 * Time: 22:19
 */

namespace Ainias\CalDav\NoDb\Property;


class ReferenceProperty extends Property
{
    /**
     * ReferenceProperty constructor.
     */
    public function __construct($href = null)
    {
        if ($href != null)
        {
            $this->setHref($href);
        }
    }

    public function setHref($href)
    {
        $this->setProperty(Property::PROP_HREF, $href);
    }

    public function getHref()
    {
        return $this->getProperty(Property::PROP_HREF);
    }
}