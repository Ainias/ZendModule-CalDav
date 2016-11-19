<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 16.11.16
 * Time: 17:31
 */

namespace Ainias\CalDav\NoDb\Essentials;


use Ainias\CalDav\NoDb\PropertyFilter;

class DefaultPropertyFilterParser extends AbstractPropertyFilterParser
{
    /** @var  string */
    private $caldavUrl;

    /**
     * DefaultPropertyFilterParser constructor.
     * @param string $caldavUrl
     */
    public function __construct($caldavUrl)
    {
        parent::__construct();
        $this->caldavUrl = $caldavUrl;
    }

    public function parseXmlToPropertyFilter($xmlStream, $propertyFilter = null)
    {
        if ($propertyFilter == null)
        {
            $propertyFilter = new PropertyFilter();
        }

        $xmlElement = new \SimpleXMLElement($xmlStream);
        $this->addNamespacesFromXmlElement($xmlElement);
        if (strtolower($xmlElement->getName()) == "propfind");
        {
            $children = $this->getAllChildren($xmlElement);
            foreach ($children as $child)
            {
                switch ($child->getName())
                {
                    case "prop":
                    {
                        $this->addFields($propertyFilter, $child);
                        break;
                    }
                    case "href":
                    {
                        $this->addHref($propertyFilter, $child->getSimpleXMLElement());
                        break;
                    }
                }
            }
        }

        return $propertyFilter;
    }

    protected function addFields(PropertyFilter $propertyFilter, $xmlProp)
    {
        $fields = $this->getAllChildren($xmlProp);
        foreach ($fields as $field)
        {
            $propertyFilter->addField($this->getFullName($field));
        }
    }

    protected function addHref(PropertyFilter $filter, $href)
    {
        if (substr($href, 0, strlen($this->caldavUrl)) === $this->caldavUrl)
        {
            $href = substr($href, strlen($this->caldavUrl));
        }
        if ($href[0] == "/")
        {
            $href = substr($href, 1);
        }
        $filter->addPropertyHref($href);
    }
}