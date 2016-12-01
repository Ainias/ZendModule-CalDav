<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 13.11.16
 * Time: 03:53
 */

namespace Ainias\CalDav\NoDb\Essentials;


use Ainias\CalDav\NoDb\ICalendar\VCalendar;
use Ainias\CalDav\NoDb\ICalendar\VEvent;
use Ainias\CalDav\NoDb\Property\ArrayProperty;
use Ainias\CalDav\NoDb\Property\CalendarProperty;
use Ainias\CalDav\NoDb\Property\EventProperty;
use Ainias\CalDav\NoDb\Property\ParentProperty;
use Ainias\CalDav\NoDb\Property\Property;
use Ainias\CalDav\NoDb\Property\ReferenceProperty;
use Ainias\CalDav\NoDb\PropertyFilter;

class DummyRepository extends FilterRepository
{
    /**
     * DummyRepository constructor.
     */
    public function __construct()
    {
        $properties = [];

        $userOne = new ParentProperty("user1", []);
        $userTwo = new ParentProperty("user2", []);
//        $properties[] = $userOne;
//        $properties[] = $userTwo;

        $calendarProperty = new CalendarProperty("calendar", [
            Property::PROP_DISPLAY_NAME => "Ein Klender",
            Property::PROP_GET_CONTENT_TYPE => "httpd/unix-directory",
            Property::PROP_RESOURCE_TYPE => new Property(["d:collection" => null, "c:calendar" => null]),
            Property::PROP_CURRENT_USER_PRINCIPAL => $userOne->getAsReference(),
            Property::PROP_OWNER => $userTwo->getAsReference(),
            Property::PROP_SUPPORTED_REPORT_SET => new ArrayProperty(Property::PROP_SUPPORTED_REPORT, [
                new Property(["d:report" => new Property(["c:calendar-query"])]),
                new Property(["d:report" => new Property(["c:calendar-multiget"])]),
                new Property(["d:report" => new Property(["d:principal-property-search"])]),
                new Property(["d:report" => new Property(["d:principal-search-property-set"])]),
            ]),
            Property::PROP_SUPPORTED_CALENDAR_COMPONENT_SET => new Property(['c:comp name = "VEVENT"'])
        ]);
        $properties[] = $calendarProperty;
        $userOne->setProperty(Property::PROP_CALENDAR_HOME_SET, $calendarProperty->getAsReference());
        $userTwo->setProperty(Property::PROP_CALENDAR_HOME_SET, $calendarProperty->getAsReference());

        $vEvent = new VEvent();
        $vEvent->setUid("0010");
        $vEvent->setSummary("Odine");
        $vEvent->setDtstart(\DateTime::createFromFormat("Y-m-d H:i:s", "2016-11-19 12:30:05"));
        $vEvent->setDtend(\DateTime::createFromFormat("Y-m-d H:i:s", "2016-11-19 13:29:08"));

        $vCalendar = new VCalendar();
        $vCalendar->setVersion("2.0");
        $vCalendar->setCalscale("GREGORIAN");
        $vCalendar->addVEvent($vEvent);

        $firstEvent = new EventProperty("firstEvent", [
            Property::PROP_GET_CONTENT_TYPE => "text/calendar; component=vevent",
            Property::PROP_RESOURCE_TYPE => null,
            Property::PROP_CALENDA_DATA => $vCalendar
        ]);
        $firstEvent->createETag();
        $properties[] = $firstEvent;
        $calendarProperty->addEvent($firstEvent);

        $vEvent = new VEvent();
        $vEvent->setUid("0011");
        $vEvent->setSummary("Nix Odin :p");
        $vEvent->setDtstart(\DateTime::createFromFormat("Y-m-d H:i:s", "2016-11-22 12:30:05"));
        $vEvent->setDtend(\DateTime::createFromFormat("Y-m-d H:i:s", "2016-11-22 13:29:08"));

        $vCalendar = new VCalendar();
        $vCalendar->setVersion("2.0");
        $vCalendar->setCalscale("GREGORIAN");
        $vCalendar->addVEvent($vEvent);

        $secondEvent = new EventProperty("secondEvent", [
            Property::PROP_GET_CONTENT_TYPE => "text/calendar; component=vevent",
            Property::PROP_RESOURCE_TYPE => null,
            Property::PROP_CALENDA_DATA => $vCalendar
        ]);
        $secondEvent->createETag();
        $properties[] = $secondEvent;
        $calendarProperty->addEvent($secondEvent);

        $calendarProperty->createCTag();
        parent::__construct($properties);
    }
}