<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 13.11.16
 * Time: 03:54
 */

namespace Ainias\CalDav\NoDb\Property;

use Zend\View\Renderer\RendererInterface;

class Property
{
    const PROP_ETAG = "d:getetag";
    const PROP_CTAG = "cs:getctag";
    const PROP_CALENDA_DATA = "c:calendar-data";
    const PROP_DISPLAY_NAME = "d:displayname";
    const PROP_RESOURCE_TYPE = "d:resourcetype";
    const PROP_OWNER = "d:owner";
    const PROP_CURRENT_USER_PRINCIPAL = "d:current-user-principal";
    const PROP_SUPPORTED_REPORT_SET = "d:supported-report-set";
    const PROP_SUPPORTED_REPORT = "d:supported-report";
    const PROP_SUPPORTED_CALENDAR_COMPONENT_SET = "c:supported-calendar-component-set";

    const PROP_HREF = "d:href";

    const PROP_GET_CONTENT_TYPE = "d:getcontenttype";

    const PROP_CALENDAR_HOME_SET = "c:calendar-home-set";

    /** @var string[] */
    private $properties;

    /** @var Property[] */
    private $children;

    private $prepared;

    /**
     * Property constructor.
     * @param \string[] $properties
     */
    public function __construct(array $properties = [])
    {
        $this->properties = [];
        $this->setProperties($properties);
        $this->prepared = false;
    }

    /**
     * @return mixed
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param mixed $properties
     */
    public function setProperties($properties)
    {
        $this->properties = [];
        foreach ($properties as $name => $property)
        {
            $this->setProperty($name, $property);
        }
    }

    public function setProperty($name, $value)
    {
        $this->properties[$name] = $value;
        if ($value instanceof Property)
        {
            $this->children[] = $value;
        }
    }

    public function getProperty($name)
    {
        if (isset($this->properties[$name]))
        {
            return $this->properties[$name];
        }
        return null;
    }

    public function hasProperty($name)
    {
        return isset($this->properties[$name]);
    }

    public function __toString()
    {
        $propertyString = "";
        $properties = $this->getProperties();
        foreach ($properties as $name => $value)
        {
            $propertyString .= $this->singlePropertyToString($name, $value).PHP_EOL;
        }
        return $propertyString;
    }

    protected function singlePropertyToString($name, $value)
    {
        if ($name == null || is_int($value))
        {
            $name = $value;
            $value = null;
        }
        if ($value == null)
        {
            return "<".$name."/>";
        }
        else
        {
            if ($value instanceof Property)
            {
                $value = PHP_EOL.$value->__toString();
            }
            return "<".$name.">".$value."</".$name.">";
        }
    }

    /**
     * @return Property[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param Property[] $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    public function prepare(RendererInterface $renderer)
    {
        if (!$this->prepared)
        {
            $this->doPrepare($renderer);
            $this->prepareChildren($renderer);
            $this->prepared = true;
        }
    }

    protected function prepareChildren(RendererInterface $renderer)
    {
        foreach ($this->children as $child)
        {
            $child->prepare($renderer);
        }
    }

    protected function doPrepare(RendererInterface $renderer)
    {

    }
}