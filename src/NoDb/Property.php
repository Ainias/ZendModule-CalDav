<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 13.11.16
 * Time: 03:54
 */

namespace Ainias\CalDav\NoDb;


class Property
{
    const PROP_ETAG = "d:getetag";
    const PROP_CTAG = "c:getetag";
    const PROP_CALENDA_DATA = "c:calenda-data";
    const PROP_DISPLAY_NAME = "d:displayname";

    /** @var string */
    private $href;

    /** @var string[] */
    private $properties;

    /** @var int */
    private $status;
    /**
     * @return mixed
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @param mixed $href
     */
    public function setHref($href)
    {
        $this->href = $href;
    }

    /**
     * @return mixed
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param mixed $properties
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setProperty($name, $value)
    {
        $this->properties[$name] = $value;
    }

    public function getProperty($name)
    {
        if (isset($this->properties[$name]))
        {
            return $this->properties[$name];
        }
        return null;
    }
}