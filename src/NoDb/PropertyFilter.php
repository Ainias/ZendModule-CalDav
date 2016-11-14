<?php
/**
 * Created by PhpStorm.
 * User: silas
 * Date: 08.11.16
 * Time: 18:53
 */

namespace Ainias\CalDav\NoDb;


class PropertyFilter
{
    /** @var array */
    private $selectedFields;

    /**
     * AppointmentFilter constructor.
     */
    public function __construct()
    {
        $this->selectedFields = [];
    }

    public function addField($field)
    {
        if (!in_array($field, $this->selectedFields))
        {
            $this->selectedFields[] = $field;
        }
    }

    /**
     * @return array
     */
    public function getSelectedFields()
    {
        return $this->selectedFields;
    }
}