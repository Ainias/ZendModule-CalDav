<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 08.11.16
 * Time: 10:24
 */

namespace Ainias\CalDav\NoDb\ICalendar;


abstract class VComponent
{
    public function __toString()
    {
        $string = "BEGIN:" . $this->getComponentName().PHP_EOL;
        $reflection = new \ReflectionClass($this);
        $properties = $reflection->getProperties();
        foreach ($properties as $property) {
            $string .= $this->getPropertyLine($property);
        }
        return $string . "END:" . $this->getComponentName();
    }

    protected function getPropertyLine(\ReflectionProperty $property)
    {
        $string = "";
        $property->setAccessible(true);
        $value = $property->getValue($this);
        if ($value != null) {
            $string .= $this->formatPropertyName($property->getName()) . ":";
            if ($value instanceof \DateTime) {
                $string .= $this->dateTimeToString($value);
            } else {
                $string .= $value;
            }
            $string .= PHP_EOL;
        }
        return $string;
    }

    protected function dateTimeToString(\DateTime $dateTime)
    {
        return $dateTime->format("Ymd\THis");
    }

    protected function formatPropertyName($propertyName)
    {
        return ltrim(strtoupper(preg_replace('/[A-Z]/', '-$0', $propertyName)), '_');
    }

    protected function getTimeZoneId()
    {
        return "TZID=" . date_default_timezone_get();
    }

    abstract protected function getComponentName();
}