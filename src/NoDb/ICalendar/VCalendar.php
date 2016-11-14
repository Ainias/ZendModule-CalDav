<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 13.11.16
 * Time: 06:59
 */

namespace Ainias\CalDav\NoDb\ICalendar;


class VCalendar extends VComponent
{
    /** @var  string */
    protected $version;

    /** @var  string */
    protected $calscale;

    /** @var  VEvent[] */
    protected $vEvents;

    protected function getComponentName()
    {
        return "VCALENDAR";
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getCalscale()
    {
        return $this->calscale;
    }

    /**
     * @param string $calscale
     */
    public function setCalscale($calscale)
    {
        $this->calscale = $calscale;
    }

    /**
     * @return VEvent[]
     */
    public function getVEvents()
    {
        return $this->vEvents;
    }

    /**
     * @param VEvent[] $vEvents
     */
    public function setVEvents($vEvents)
    {
        $this->vEvents = $vEvents;
    }

    public function addVEvent(VEvent $event)
    {
        $this->vEvents[] = $event;
    }

    protected function getPropertyLine(\ReflectionProperty $property)
    {
        if ($property->getName() == "vEvents")
        {
            $eventString = "";
            $property->setAccessible(true);
            foreach ($property->getValue($this) as $vEvent)
            {
                $eventString .= $vEvent.PHP_EOL;
            }
            return $eventString;
        }
        else
        {
            return parent::getPropertyLine($property);
        }
    }
}