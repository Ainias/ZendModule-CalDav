<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 19.11.16
 * Time: 12:12
 */

namespace Ainias\CalDav\NoDb\Property;


class EventProperty extends ParentProperty
{
    public function createETag()
    {
        $this->setProperty(Property::PROP_ETAG, md5($this->__toString()));
    }
}