<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 14.11.16
 * Time: 22:19
 */

namespace Ainias\CalDav\NoDb\Property;


use Zend\View\Renderer\RendererInterface;

class ReferenceProperty extends Property
{
    /**
     * ReferenceProperty constructor.
     * @param null $href
     * @param array $properties
     */
    public function __construct($href = null, $properties = [])
    {
        parent::__construct($properties);
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

    protected function doPrepare(RendererInterface $renderer)
    {
        $this->setHref($renderer->url("calDav", ["propertyHref" => $this->getHref()]));
    }
}