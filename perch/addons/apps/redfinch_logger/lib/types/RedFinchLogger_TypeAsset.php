<?php

/**
 * Class RedFinchLogger_TypeAsset
 *
 * @author James Wigger <james.s.wigger@gmail.com>
 */
class RedFinchLogger_TypeAsset extends RedFinchLogger_TypeBase
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
        $extension = '.' . pathinfo($subject->web_path, PATHINFO_EXTENSION);
        $thumb  = '-thumb@2x' . $extension;

        return [
            'title' => $subject->file_name,
            'media' => str_replace($extension, $thumb, $subject->web_path)
        ];
    }
}
