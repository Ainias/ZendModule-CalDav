<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 08.11.16
 * Time: 13:35
 */

namespace Ainias\CalDav\NoDb\Request;

use Ainias\CalDav\NoDb\PropertyFilter;

class RequestManager
{
    public function extractXML($xmlRequest)
    {
        $xmlElement = $this->requestToObject($xmlRequest);

        $href = $xmlElement->xpath("//D:href");
        if (!isset($href[0]) || !($href[0] instanceof \SimpleXMLElement))
        {
            throw new PropertyNotSetException("Property href not found!");
        }

        $prop = $xmlElement->xpath("//D:prop");
        if (!isset($prop[0]) || !($prop[0] instanceof \SimpleXMLElement))
        {
            throw new PropertyNotSetException("Property prop not found!");
        }

        $filter = $this->buildFilter($prop[0]);
        $filter->setPropertyHref((string)$href[0]);
        return $filter;
    }

    protected function buildFilter(\SimpleXMLElement $XMLElement)
    {
        $filter = new PropertyFilter();
        $namespaces = $XMLElement->getDocNamespaces();
        foreach ($namespaces as $alias => $namespace)
        {
            $childXMLElement = $XMLElement->children($namespace);
            foreach ($childXMLElement as $name => $prop)
            {
                $filter->addField($alias.":".$name);
            }
        }
        return $filter;
    }

    protected function requestToObject($xmlRequest)
    {
        $xmlElement = new \SimpleXMLElement($xmlRequest);
        return $xmlElement;
    }

    protected function getResultForFilter(PropertyFilter $filter)
    {

    }
}