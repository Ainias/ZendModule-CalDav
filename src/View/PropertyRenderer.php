<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 13.11.16
 * Time: 06:29
 */

namespace Ainias\CalDav\View;


use Ainias\CalDav\NoDb\Property;
use Zend\View\Helper\AbstractHelper;

class PropertyRenderer extends AbstractHelper
{
    public function __invoke($properties)
    {
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
        $propertyString = "";
        $properties = $property->getProperties();
        $status = ($property->getStatus()==200?"200 OK":"404 NOT FOUND");
        foreach ($properties as $name => $value)
        {
            $propertyString .= "<".$name.">".$value."</".$name.">\n";
        }

        $href = $property->getHref();
        return <<<XML
<d:response>
        <d:href>$href</d:href>
        <d:propstat>
            <d:prop>
                $propertyString
            </d:prop>
            <d:status>HTTP/1.1 $status</d:status>
        </d:propstat>
    </d:response>
XML;
    }
}