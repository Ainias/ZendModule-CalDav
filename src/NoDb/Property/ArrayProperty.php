<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 15.11.16
 * Time: 11:35
 */

namespace Ainias\CalDav\NoDb\Property;

class ArrayProperty extends Property
{
    /** @var string */
    private $name;

    /** @var array */
    private $values;

    /**
     * ArrayProperty constructor.
     * @param string $name
     * @param array $values
     */
    public function __construct($name, array $values)
    {
        $this->name = $name;
        $this->values = $values;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param array $values
     */
    public function setValues($values)
    {
        $this->values = $values;
    }

    public function addValue($value)
    {
        $this->values[] = $value;
    }

    public function setValue($position, $value)
    {
        $this->values[$position] = $value;
    }

    public function getValue($position)
    {
        return $this->values[$position];
    }

    public function __toString()
    {
        $propertyString = parent::__toString();
        foreach ($this->values as $value)
        {
            $propertyString .= $this->singlePropertyToString($this->name, $value);
        }
        return $propertyString;
    }
}
