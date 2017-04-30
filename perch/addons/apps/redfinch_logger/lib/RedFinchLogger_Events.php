<?php

/**
 * Class RedFinchLogger_Events
 *
 * @author James Wigger <james.s.wigger@gmail.com>
 */
class RedFinchLogger_Events extends PerchAPI_Factory
{
    /**
     * Events table
     *
     * @var string
     */
    protected $table = 'redfinch_logger_events';

    /**
     * Primary Key
     *
     * @var string
     */
    protected $pk = 'eventID';

    /**
     * Sort column
     *
     * @var string
     */
    protected $default_sort_column = 'eventTriggered';

    /**
     * Sort direction
     *
     * @var string
     */
    protected $default_sort_direction = 'DESC';

    /**
     * Factory singular class
     *
     * @var string
     */
    protected $singular_classname = 'RedFinchLogger_Event';

    /**
     * Template namespace
     *
     * @var string
     */
    protected $namespace = 'logger';

    /**
     * Event type filter value
     *
     * @var null|string
     */
    protected $typeFilter;

    /**
     * Event action filter value
     *
     * @var null|string
     */
    protected $actionFilter;

    /**
     * Event user filter value
     *
     * @var null|string
     */
    protected $userFilter;

    /**
     * Returns a unique list of event types that have been logged
     *
     * @return array
     */
    public function getEventTypes()
    {
        $sql = 'SELECT DISTINCT `eventType` FROM `' . $this->table . '`';

        $result = $this->db->get_rows($sql);

        return array_map(function($item) {
            return $item['eventType'];
        }, $result);
    }

    /**
     * Returns a unique list of event actions that have been logged
     *
     * @return array
     */
    public function getEventActions()
    {
        $sql = 'SELECT DISTINCT `eventAction` FROM `' . $this->table . '`';

        $result = $this->db->get_rows($sql);

        return array_map(function($item) {
            return $item['eventAction'];
        }, $result);
    }

    /**
     * Clear logs older than the given number of days
     *
     * @param int $days
     *
     * @return mixed
     */
    public function prune($days)
    {
        $now = new DateTime();
        $cutoff = $now->sub(new DateInterval('P' . $days . 'D'));

        $sql = 'DELETE FROM ' . $this->table . ' WHERE `eventTriggered` <= ' . $this->db->pdb($cutoff->format('Y-m-d H:i:s'));

        return $this->db->execute($sql);
    }

    /**
     * Set region filter value
     *
     * @param string $type
     *
     * @return $this
     */
    public function filterByType($type)
    {
        $this->typeFilter = $type;

        return $this;
    }

    /**
     * Set action filter value
     *
     * @param string $action
     *
     * @return $this
     */
    public function filterByAction($action)
    {
        $this->actionFilter = $action;

        return $this;
    }

    /**
     * Set user ID filter value
     *
     * @param int $userID
     *
     * @return $this
     */
    public function filterByUser($userID)
    {
        $this->userFilter = $userID;

        return $this;
    }

    /**
     * Add constraints to any system query
     *
     * @return string
     */
    protected function standard_restrictions()
    {
        $sql = '';

        if($this->typeFilter) {
            $sql .= ' AND `eventType` = ' . $this->db->pdb($this->typeFilter);
        }

        if($this->actionFilter) {
            $sql .= ' AND `eventAction` = ' . $this->db->pdb($this->actionFilter);
        }

        if($this->userFilter) {
            $sql .= ' AND `eventUserID` = ' . $this->db->pdb($this->userFilter);
        }

        return $sql;
    }
}
