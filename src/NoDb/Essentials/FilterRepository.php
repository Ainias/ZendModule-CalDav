<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 17.11.16
 * Time: 11:33
 */

namespace Ainias\CalDav\NoDb\Essentials;


use Ainias\CalDav\NoDb\Property\ParentProperty;
use Ainias\CalDav\NoDb\Property\Property;
use Ainias\CalDav\NoDb\PropertyFilter;
use Ainias\CalDav\NoDb\XMLElement;

class FilterRepository implements PropertyRepository
{
    /** @var ParentProperty[] */
    public $properties;

    /**
     * FilterRepository constructor.
     * @param ParentProperty[] $properties
     */

    public function __construct(array $properties = [])
    {
        $this->setProperties($properties);
    }


    public function query(PropertyFilter $filter)
    {
        $properties = $this->filterProperties($filter,$this->properties);
        return $this->selectFields($filter, $properties);
    }

    protected function selectFields(PropertyFilter $filter, array $properties)
    {
        /** @var Property $property */
        foreach ($properties as $property) {
            $fields = [];
            $missingFields = [];
            foreach ($filter->getSelectedFields() as $selectedField) {
                if ($property->hasProperty($selectedField)) {
                    $fields[$selectedField] = $property->getProperty($selectedField);
                } else {
                    $missingFields[$selectedField] = null;
                }
            }
            $property->setProperties($fields);
            if ($property instanceof ParentProperty) {
                $property->setFailedProperties($missingFields);
            }
        }
        return $properties;
    }

    /**
     * @param PropertyFilter $filter
     * @param ParentProperty[] $properties
     * @return mixed
     */
    protected function filterProperties(PropertyFilter $filter, $properties)
    {
        $filteredProperties = [];
        $hrefs = $filter->getPropertyHrefs();
        $rootHref = $filter->getRootHref();
        if ($rootHref != null && $rootHref != "")
        {
            $rootProperty = $properties[$rootHref];
            $properties = $rootProperty->getSubParentProperties();
            $properties[$rootProperty->getHref()] = $rootProperty;
        }

        if (count($hrefs) >0)
        {
            foreach ($properties as $property)
            {
                if (in_array($property->getHref(), $hrefs))
                {
                    $filteredProperties[] = $property;
                }
            }
            return $filteredProperties;
        }
        return $properties;
    }

    public function addProperty(ParentProperty $property)
    {
        $this->properties[$property->getHref()] = $property;
    }

    /**
     * @return ParentProperty[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param ParentProperty[] $properties
     */
    public function setProperties($properties)
    {
        $this->properties = [];
        foreach ($properties as $property)
        {
            $this->addProperty($property);
        }
    }
}