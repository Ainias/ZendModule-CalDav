<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 17.11.16
 * Time: 09:58
 */

namespace Ainias\CalDav\NoDb\Essentials;


use Ainias\CalDav\NoDb\PropertyFilter;

interface PropertyFilterParser
{
    /**
     * @param $xmlStream
     * @param PropertyFilter|null $filter
     * @return PropertyFilter
     */
    public function parseXmlToPropertyFilter($xmlStream, $filter = null);
}