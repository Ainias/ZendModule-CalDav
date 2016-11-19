<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 08.11.16
 * Time: 18:53
 */

namespace Ainias\CalDav\NoDb;


class PropertyFilter
{
    /** @var array */
    private $selectedFields;

    /** @var array */
    private $propertyHrefs;

    private $rootHref;

    /**
     * AppointmentFilter constructor.
     */
    public function __construct()
    {
        $this->selectedFields = [];
        $this->rootHref = null;
    }

    public function addField($field)
    {
        if (!in_array($field, $this->selectedFields))
        {
            $this->selectedFields[] = $field;
        }
    }

    /**
     * @return array
     */
    public function getSelectedFields()
    {
        return $this->selectedFields;
    }

    /**
     * @return array
     */
    public function getPropertyHrefs()
    {
        return $this->propertyHrefs;
    }

    /**
     * @param array $propertyHrefs
     */
    public function setPropertyHrefs($propertyHrefs)
    {
        $this->propertyHrefs = $propertyHrefs;
    }

    public function addPropertyHref($propertyHref)
    {
        $this->propertyHrefs[] = $propertyHref;
    }

    /**
     * @return null
     */
    public function getRootHref()
    {
        return $this->rootHref;
    }

    /**
     * @param null $rootHref
     */
    public function setRootHref($rootHref)
    {
        $this->rootHref = $rootHref;
    }
}