<?php

/**
 * Class RedFinchLogger_TypeBase
 *
 * @author James Wigger <james.s.wigger@gmail.com>
 */
abstract class RedFinchLogger_TypeBase
{
    /**
     * Event subject object
     *
     * @var mixed
     */
    protected $subject;

    /**
     * Subject unique ID
     *
     * @var int
     */
    protected $id;

    /**
     * Subject human identifiable title
     *
     * @var string
     */
    protected $title;

    /**
     * Subject content
     *
     * @var string
     */
    protected $content;

    /**
     * File path for uploaded media
     *
     * @var string
     */
    protected $media;

    /**
     * RedFinchLogger_TypeBase constructor.
     *
     * @param $subject
     */
    public function __construct($subject)
    {
        $this->subject = $subject;

        $this->hydrateFromSubject();
    }

    /**
     * @return mixed
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return RedFinchLogger_TypeBase
     */
    public function setID($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return RedFinchLogger_TypeBase
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return RedFinchLogger_TypeBase
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param string $media
     *
     * @return RedFinchLogger_TypeBase
     */
    public function setMedia($media)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Returns an array from the subject mapped to the common type properties
     *
     * @param $subject
     *
     * @return array
     */
    abstract protected function map($subject);

    /**
     * Populates type properties from subject data
     *
     * @return $this
     */
    protected function hydrateFromSubject()
    {
        $properties = $this->map($this->subject);

        $this->hydrate($properties);

        return $this;
    }

    /**
     * Populate item properties from array
     *
     * @param array $properties
     *
     * @return $this
     */
    protected function hydrate(array $properties)
    {
        // Merge with default empty values
        $properties = array_merge([
            'id'      => 0,
            'title'   => null,
            'content' => null,
            'media'   => false
        ], $properties);

        $this->setID($properties['id']);
        $this->setTitle($properties['title']);
        $this->setContent($properties['content']);
        $this->setMedia($properties['media']);

        return $this;
    }

    /**
     * Return type in array format
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id'      => $this->getID(),
            'title'   => $this->getTitle(),
            'content' => $this->getContent(),
            'media'   => $this->getMedia()
        ];
    }
}
