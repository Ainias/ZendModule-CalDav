<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 16.11.16
 * Time: 17:30
 */

namespace Ainias\CalDav\NoDb\Essentials;


use Ainias\CalDav\NoDb\XMLElement;

abstract class AbstractPropertyFilterParser implements PropertyFilterParser
{
    protected $namespaceAliases = [];

    /**
     * AbstractPropertyFilterParser constructor.
     */
    public function __construct()
    {
        $this->registerNamespaceAlias(XMLElement::NAMESPACE_D, "d");
        $this->registerNamespaceAlias(XMLElement::NAMESPACE_C, "c");
        $this->registerNamespaceAlias(XMLElement::NAMESPACE_CS, "cs");
        $this->registerNamespaceAlias(XMLElement::NAMESPACE_IC, "ic");
    }

    public function registerNamespaceAlias($namespace, $alias)
    {
        $namespace = strtolower($namespace);
        $alias = strtolower($alias);
        if (!isset($this->namespaceAliases[$namespace]))
        {
            $this->namespaceAliases[$namespace] = $alias;
        }
    }

    public function getNamespaceAlias($namespace)
    {
        $namespace = strtolower($namespace);
        if (isset($this->namespaceAliases[$namespace]))
        {
            return $this->namespaceAliases[$namespace];
        }
        return null;
    }

    /**
     * @param $xmlElement
     * @return XMLElement[]
     */
    public function getAllChildren($xmlElement)
    {
        if ($xmlElement instanceof XMLElement)
        {
            /** @var \SimpleXMLElement $xmlElement */
            $xmlElement = $xmlElement->getSimpleXMLElement();
        }
        $children = [];
        $namespaces = $xmlElement->getNamespaces(true);
        foreach ($namespaces as $namespace)
        {
            $tmpChildren = $xmlElement->children($namespace);
            foreach ($tmpChildren as $tmpChild)
            {
                $children[] = new XMLElement($namespace, $tmpChild);
            }
        }
        return $children;
    }

    public function getFullName(XMLElement $element, $useAlias = true)
    {
        $namespace = ($useAlias)?$this->getNamespaceAlias($element->getNodeNamespace()):$element->getNodeNamespace();
        return $namespace.":".$element->getName();
    }

    public function addNamespacesFromXmlElement(\SimpleXMLElement $element)
    {
        $namespaces = $element->getNamespaces(true);
        foreach ($namespaces as $alias => $namespace)
        {
            $this->registerNamespaceAlias($namespace, $alias);
        }
    }
}