<?php

/**
 * Class RedFinchLogger_TypeItem
 *
 * @author James Wigger <james.s.wigger@gmail.com>
 */
class RedFinchLogger_TypeItem extends RedFinchLogger_TypeBase
{
    /**
     * Returns an array from the subject mapped to the common type properties
     *
     * @param $subject
     *
     * @return array
     */
    protected function map($subject)
    {
        $Regions = new PerchContent_Regions();
        $region = $Regions->find($subject->regionID());

        return [
            'id'      => $subject->itemID(),
            'title'   => $region->regionKey(),
            'content' => $subject->itemSearch()
        ];
    }
}