<?php

/**
 * Class RedFinchLogger_TypeCategory
 *
 * @author James Wigger <james.s.wigger@gmail.com>
 */
class RedFinchLogger_TypeCategory extends RedFinchLogger_TypeBase
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
            'id'      => $subject->id(),
            'title'   => $subject->catTitle(),
            'content' => $subject->catPath(),
        ];
    }
}
