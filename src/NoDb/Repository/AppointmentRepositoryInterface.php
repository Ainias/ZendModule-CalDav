<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 08.11.16
 * Time: 22:40
 */

namespace Ainias\CalDav\NoDb\Repository;


use Ainias\CalDav\NoDb\PropertyFilter;

interface AppointmentRepositoryInterface
{
    public function propfind(PropertyFilter $filter);

    public function calendarQuery(PropertyFilter $filter);
}