<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 16.11.16
 * Time: 17:30
 */

namespace Ainias\CalDav\NoDb\Essentials;


interface PropertyFilterParser
{
    public function parseXmlToPropertyFilter($xmlStream);
}