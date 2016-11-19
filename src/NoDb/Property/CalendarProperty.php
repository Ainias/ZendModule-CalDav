<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 19.11.16
 * Time: 11:56
 */

namespace Ainias\CalDav\NoDb\Property;

class CalendarProperty extends ParentProperty
{
    /** @var  EventProperty[] */
    private $events;

    public function __construct($href = null, array $properties = [])
    {
        parent::__construct($href, $properties);
        $this->events = [];
    }


    public function createCTag()
    {
        $string = $this->__toString();
        foreach ($this->events as $event)
        {
            $string .= $event->__toString();
        }
        $this->setProperty(Property::PROP_CTAG, md5($string));
    }

    /**
     * @return EventProperty[]
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param EventProperty[] $events
     */
    public function setEvents($events)
    {
        $this->events = [];
        foreach ($events as $event)
        {
            $this->addEvent($event);
        }
    }

    public function addEvent($event)
    {
        $this->events[] = $event;
        $this->addSubParentProperty($event);
    }
}