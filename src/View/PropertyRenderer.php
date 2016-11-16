<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 13.11.16
 * Time: 06:29
 */

namespace Ainias\CalDav\View;

use Ainias\CalDav\NoDb\Property\InlineProperty;
use Ainias\CalDav\NoDb\Property\Property;
use Zend\View\Helper\AbstractHelper;

class PropertyRenderer extends AbstractHelper
{
    public function __invoke($properties = null)
    {
        if ($properties == null)
        {
            return $this;
        }

        if ($properties instanceof Property)
        {
            return $this->renderProperty($properties);
        }
        else
        {
            return $this->renderProperties($properties);
        }
    }

    public function renderProperties($properties)
    {
        $propertyString = "";
        /** @var Property $property */
        foreach ($properties as $property)
        {
            $propertyString .= $this->renderProperty($property);
        }
        return $propertyString;
    }

    public function renderProperty(Property $property)
    {
        return $property->__toString();
    }
}