<?php

/**
 * Class RedFinchLogger_TypeRegion
 *
 * @author James Wigger <james.s.wigger@gmail.com>
 */
class RedFinchLogger_TypeRegion extends RedFinchLogger_TypeBase
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
        return [
            'id' => $subject->id(),
            'title' => $subject->regionKey(),
            'content' => $subject->regionHTML()
        ];
    }

}
