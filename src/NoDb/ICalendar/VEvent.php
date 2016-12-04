<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 08.11.16
 * Time: 10:15
 */

namespace Ainias\CalDav\NoDb\ICalendar;


class VEvent extends VComponent
{
    /** @var  \DateTime */
    protected $created;

    /** @var  \DateTime */
    protected $lastModified;

    /** @var  \DateTime */
    protected $dtstamp;

    /** @var  string */
    protected $uid;

    /** @var  string */
    protected $summary;

    /** @var  \DateTime */
    protected $dtstart;

    /** @var  \DateTime */
    protected $dtend;

    /** @var  string */
    protected $transp;

    /** @var  string */
    protected $description;

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * @param \DateTime $lastModified
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;
    }

    /**
     * @return \DateTime
     */
    public function getDtstamp()
    {
        return $this->dtstamp;
    }

    /**
     * @param \DateTime $dtstamp
     */
    public function setDtstamp($dtstamp)
    {
        $this->dtstamp = $dtstamp;
    }

    /**
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param string $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param string $summary
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    /**
     * @return \DateTime
     */
    public function getDtstart()
    {
        return $this->dtstart;
    }

    /**
     * @param \DateTime $dtstart
     */
    public function setDtstart($dtstart)
    {
        $this->dtstart = $dtstart;
    }

    /**
     * @return \DateTime
     */
    public function getDtend()
    {
        return $this->dtend;
    }

    /**
     * @param \DateTime $dtend
     */
    public function setDtend($dtend)
    {
        $this->dtend = $dtend;
    }

    /**
     * @return string
     */
    public function getTransp()
    {
        return $this->transp;
    }

    /**
     * @param string $transp
     */
    public function setTransp($transp)
    {
        $this->transp = $transp;
    }


    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    protected function getPropertyLine(\ReflectionProperty $property)
    {
        $string = "";
        if ($property->getName() == "dtstart" || $property->getName() == "dtend")
        {
            $property->setAccessible(true);
            $string .= $this->formatPropertyName($property->getName()).";".$this->getTimeZoneId().":".$this->dateTimeToString($property->getValue($this)).PHP_EOL;
        }
        else
        {
            $string .= parent::getPropertyLine($property);
        }
        return $string;
    }

    protected function getComponentName()
    {
        return "VEVENT";
    }
}
