<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 13.11.16
 * Time: 03:53
 */

namespace Ainias\CalDav\NoDb\Repository;


use Ainias\CalDav\NoDb\ICalendar\VCalendar;
use Ainias\CalDav\NoDb\ICalendar\VEvent;
use Ainias\CalDav\NoDb\Property;
use Ainias\CalDav\NoDb\PropertyFilter;

class DummyRepository implements AppointmentRepositoryInterface
{
    protected $calendarProperties;
    protected $vCalendarProperties;

    /**
     * DummyRepository constructor.
     */
    public function __construct()
    {
        $this->calendarProperties = [];

        $property = new Property();
        $property->setHref("firstProperty");
        $property->setProperty(Property::PROP_DISPLAY_NAME, "firstCalendar");
        $property->setProperty(Property::PROP_CTAG, "1");
        $property->setStatus(200);
        $this->calendarProperties[] = $property;

        $property = new Property();
        $property->setHref("secondProperty");
        $property->setProperty(Property::PROP_DISPLAY_NAME, "secondCalendar");
        $property->setProperty(Property::PROP_CTAG, "2");
        $property->setStatus(200);
        $this->calendarProperties[] = $property;

        $vCalendar = new VCalendar();
        $vCalendar->setVersion("2.0");
        $vCalendar->setCalscale("GREGORIAN");
        $vEvent = new VEvent();
        $vEvent->setUid("0010");
        $vEvent->setSummary("une Termine");
        $vEvent->setDtstart(\DateTime::createFromFormat("Y-m-d H:i:s", "2016-11-15 12:30:05"));
        $vEvent->setDtend(\DateTime::createFromFormat("Y-m-d H:i:s", "2016-11-15 13:29:08"));
        $vCalendar->addVEvent($vEvent);

        $property = new Property();
        $property->setHref("firstEvent");
        $property->setProperty(Property::PROP_ETAG, "44");
        $property->setProperty(Property::PROP_CTAG, "2");
        $property->setProperty(Property::PROP_CALENDA_DATA, $vCalendar);
        $property->setStatus(200);
        $this->vCalendarProperties[] = $property;
    }

    public function propfind(PropertyFilter $filter)
    {
        return $this->calendarProperties;
    }

    public function calendarQuery(PropertyFilter $filter)
    {
        return $this->vCalendarProperties;
    }
}