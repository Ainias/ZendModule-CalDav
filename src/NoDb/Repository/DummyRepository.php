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
use Ainias\CalDav\NoDb\Property\ArrayProperty;
use Ainias\CalDav\NoDb\Property\ParentProperty;
use Ainias\CalDav\NoDb\Property\Property;
use Ainias\CalDav\NoDb\Property\ReferenceProperty;
use Ainias\CalDav\NoDb\PropertyFilter;

class DummyRepository implements PropertyRepositoryInterface
{
    protected $calendarProperties;
    protected $vCalendarProperties;

    /**
     * DummyRepository constructor.
     */
    public function __construct()
    {
        $this->calendarProperties = [];

        $property = new ParentProperty();
        $property->setHref("/firstProperty");
        $property->setProperty(Property::PROP_RESOURCE_TYPE, new Property(["d:collection" => null, "c:calendar" => null]));
//        $property->setProperty(Property::PROP_DISPLAY_NAME, "firstCalendar");
        $property->setProperty(Property::PROP_CTAG, "2");
        $property->setProperty(Property::PROP_CURRENT_USER_PRINCIPAL, new ReferenceProperty("/user2"));
        $property->setProperty(Property::PROP_OWNER, new ReferenceProperty("/user1"));
        $property->setProperty(Property::PROP_SUPPORTED_REPORT_SET, new ArrayProperty(Property::PROP_SUPPORTED_REPORT, [
            new Property(["d:report" => new Property(["c:calendar-query"])]),
            new Property(["d:report" => new Property(["c:calendar-multiget"])]),
            new Property(["d:report" => new Property(["d:principal-property-search"])]),
            new Property(["d:report" => new Property(["d:principal-search-property-set"])]),
        ]));
        $property->setProperty(Property::PROP_SUPPORTED_CALENDAR_COMPONENT_SET, new Property(['c:comp name = "VEVENT"']));
        $this->calendarProperties[] = $property;

//        $property = new Property();
//        $property->setHref("secondProperty");
//        $property->setProperty(Property::PROP_DISPLAY_NAME, "secondCalendar");
//        $property->setProperty(Property::PROP_CTAG, "2");
//        $property->setStatus(200);
//        $this->calendarProperties[] = $property;

        $vCalendar = new VCalendar();
        $vCalendar->setVersion("2.0");
        $vCalendar->setCalscale("GREGORIAN");
        $vEvent = new VEvent();
        $vEvent->setUid("0010");
        $vEvent->setSummary("ein Termine");
        $vEvent->setDtstart(\DateTime::createFromFormat("Y-m-d H:i:s", "2016-11-15 12:30:05"));
        $vEvent->setDtend(\DateTime::createFromFormat("Y-m-d H:i:s", "2016-11-15 13:29:08"));
        $vCalendar->addVEvent($vEvent);

        $property = new ParentProperty();
        $property->setHref("/firstEvent");
        $property->setProperty(Property::PROP_ETAG, "500");
//        $property->setProperty(Property::PROP_CTAG, "2");
        $property->setProperty(Property::PROP_CALENDA_DATA, $vCalendar);
        $this->vCalendarProperties[] = $property;
    }

    public function propfind(PropertyFilter $filter)
    {
        return $this->calendarProperties;
    }

    public function propfindEvents()
    {
        $properties = [];
        $property = new ParentProperty([
            Property::PROP_GET_CONTENT_TYPE => "httpd/unix-directory",
            Property::PROP_RESOURCE_TYPE => new Property(["d:collection" => null, "c:calendar" => null]),
        ]);
        $property->setHref("/firstProperty");
        $property->setFailedProperties([
            Property::PROP_ETAG
        ]);
        $properties[] = $property;

        $property = new ParentProperty([
            Property::PROP_GET_CONTENT_TYPE => "text/calendar; component=vevent",
            Property::PROP_RESOURCE_TYPE,
            Property::PROP_ETAG => "500",
        ]);
        $property->setHref("/firstEvent");
        $properties[] = $property;

        return $properties;
    }

    public function calendarQuery(PropertyFilter $filter)
    {
        return $this->vCalendarProperties;
    }
}