<?php

/**
 * Class RedFinchLogger_TypePage
 *
 * @author James Wigger <james.s.wigger@gmail.com>
 */
class RedFinchLogger_TypePage extends RedFinchLogger_TypeBase
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
        // No page events seem relevant at this time.
        return [];
    }
}