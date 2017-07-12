<?php

/**
 * Class RedFinchLogger_Dispatcher
 *
 * @author James Wigger <james.s.wigger@gmail.com>
 */
class RedFinchLogger_Dispatcher
{
    /**
     * @var string
     */
    private $eventKey;

    /**
     * @var RedFinchLogger_TypeBase
     */
    private $subject;

    /**
     * @var bool
     */
    private $user;

    /**
     * RedFinchLogger_Dispatcher constructor.
     *
     * @param string                  $eventKey
     * @param RedFinchLogger_TypeBase $subject
     * @param bool                    $user
     */
    public function __construct($eventKey, RedFinchLogger_TypeBase $subject, $user = false)
    {
        $this->eventKey = $eventKey;
        $this->subject = $subject;
        $this->user = $user;
    }

    /**
     * Returns event namespace
     *
     * @return string
     */
    public function getEventType()
    {
        $string = explode('.', $this->eventKey);

        return $string[0];
    }

    /**
     * Returns event action
     *
     * @return string
     */
    public function getEventAction()
    {
        $string = explode('.', $this->eventKey);

        return $string[1];
    }

    /**
     * Returns the subject ID
     *
     * @return int
     */
    public function getSubjectID()
    {
        return $this->subject->getID();
    }

    /**
     * Returns unserialized subject data;
     *
     * @return string
     */
    public function getSubjectData()
    {
        return PerchUtil::json_safe_encode($this->subject->toArray());
    }

    /**
     * Saves the event to the database
     *
     * @return bool
     */
    public function save()
    {
        $data = [
            'eventKey'         => $this->eventKey,
            'eventType'        => $this->getEventType(),
            'eventAction'      => $this->getEventAction(),
            'eventSubjectID'   => $this->getSubjectID(),
            'eventSubjectData' => trim($this->getSubjectData()),
            'eventUserID'      => ($this->user) ? $this->user->id() : 0,
            'eventTriggered'   => date('Y-m-d H:i:s')
        ];

        $PerchAPI = new PerchAPI(1.0, 'redfinch_logger');
        $Events = new RedFinchLogger_Events($PerchAPI);

        return $Events->create($data);
    }
}