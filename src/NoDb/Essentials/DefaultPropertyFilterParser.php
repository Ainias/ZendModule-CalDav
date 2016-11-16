<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 16.11.16
 * Time: 17:31
 */

namespace Ainias\CalDav\NoDb\Essentials;


use Ainias\CalDav\NoDb\PropertyFilter;

class DefaultPropertyFilterParser implements PropertyFilterParser
{
    public function parseXmlToPropertyFilter($xmlStream)
    {
        $propertyFilter = new PropertyFilter();

        $xmlElement = new \SimpleXMLElement($xmlStream);


        return $propertyFilter;
    }

}