<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 17.11.16
 * Time: 09:44
 */

namespace Ainias\CalDav\NoDb;


class XMLElement
{
    const NAMESPACE_D = "dav:";
    const NAMESPACE_CS = "http://calendarserver.org/ns/";
    const NAMESPACE_C = "urn:ietf:params:xml:ns:caldav";
    const NAMESPACE_IC = "http://apple.com/ns/ical/";

    private $nodeNamespace;

    /** @var  \SimpleXMLElement */
    private $simpleXMLElement;

    /**
     * XMLElement constructor.
     * @param $nodeNamespace
     * @param \SimpleXMLElement $simpleXMLElement
     */
    public function __construct($nodeNamespace, \SimpleXMLElement $simpleXMLElement)
    {
        $this->setNodeNamespace($nodeNamespace);
        $this->simpleXMLElement = $simpleXMLElement;
    }

    /**
     * @return mixed
     */
    public function getNodeNamespace()
    {
        return $this->nodeNamespace;
    }

    /**
     * @param mixed $nodeNamespace
     */
    public function setNodeNamespace($nodeNamespace)
    {
        $this->nodeNamespace = strtolower($nodeNamespace);
    }

    /**
     * @return mixed
     */
    public function getSimpleXMLElement()
    {
        return $this->simpleXMLElement;
    }

    /**
     * @param mixed $simpleXMLElement
     */
    public function setSimpleXMLElement($simpleXMLElement)
    {
        $this->simpleXMLElement = $simpleXMLElement;
    }

    public function getName()
    {
        return $this->simpleXMLElement->getName();
    }
}