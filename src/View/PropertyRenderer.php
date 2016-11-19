<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 13.11.16
 * Time: 06:29
 */

namespace Ainias\CalDav\View;

use Ainias\CalDav\NoDb\Property\InlineProperty;
use Ainias\CalDav\NoDb\Property\ParentProperty;
use Ainias\CalDav\NoDb\Property\Property;
use Ainias\CalDav\NoDb\Property\ReferenceProperty;
use Zend\View\Helper\AbstractHelper;

class PropertyRenderer extends AbstractHelper
{
    public function __invoke($properties = null)
    {
        if ($properties === null)
        {
            return $this;
        }

        if ($properties instanceof Property)
        {
            $this->prepareProperty($properties);
            return $this->renderProperties([$properties]);
        }
        else
        {
            $this->prepareProperties($properties);
            return $this->renderProperties($properties);
        }
    }

    public function prepareProperties($properties)
    {
        foreach ($properties as $property)
        {
            $this->prepareProperty($property);
        }
    }
    public function prepareProperty(Property $property)
    {
        $property->prepare($this->getView());
    }

    public function renderProperties($properties)
    {
        $propertyString = '<?xml version="1.0" encoding="utf-8" ?>'.PHP_EOL.'<d:multistatus xmlns:d="DAV:" xmlns:cs="http://calendarserver.org/ns/" xmlns:c="urn:ietf:params:xml:ns:caldav" xmlns:ic="http://apple.com/ns/ical/">'.PHP_EOL;
        /** @var Property $property */
        foreach ($properties as $property)
        {
            $propertyString .= $this->renderProperty($property);
        }
        return $propertyString.PHP_EOL."</d:multistatus>";
    }

    public function renderProperty(Property $property)
    {
        return $property->__toString();
    }
}