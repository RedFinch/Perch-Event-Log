<?php

/**
 * Class RedFinchLogger_TypeCollection
 *
 * @author James Wigger <james.s.wigger@gmail.com>
 */
class RedFinchLogger_TypeCollection extends RedFinchLogger_TypeBase
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
        if(!PERCH_RUNWAY) {
            return [];
        }

        $Collections = new PerchContent_Collections();
        $collection = $Collections->find($subject->collectionID());

        return [
            'id'      => $subject->itemID(),
            'title'   => $collection->collectionKey(),
            'content' => $subject->itemSearch() // the best I can do with what's included
        ];
    }
}