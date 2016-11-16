<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 08.11.16
 * Time: 22:40
 */

namespace Ainias\CalDav\NoDb\Essentials;


use Ainias\CalDav\NoDb\PropertyFilter;

interface PropertyRepository
{
    public function query(PropertyFilter $filter);
}