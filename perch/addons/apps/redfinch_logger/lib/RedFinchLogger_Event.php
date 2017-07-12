<?php

/**
 * Class RedFinchLogger_Event
 *
 * @author James Wigger <james.s.wigger@gmail.com>
 */
class RedFinchLogger_Event extends PerchAPI_Base
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
     * Modified date column
     *
     * @var string
     */
    protected $modified_date_column = 'eventTriggered';

    /**
     * Convert row into a flattened array
     *
     * @return array
     */
    public function to_array()
    {
        $out = $this->details;

        $dynamic_field_col = str_replace('ID', 'DynamicFields', $this->pk);

        if (isset($out[$dynamic_field_col]) && $out[$dynamic_field_col] != '') {
            $dynamic_fields = PerchUtil::json_safe_decode($out[$dynamic_field_col], true);

            if (PerchUtil::count($dynamic_fields)) {
                if ($this->prefix_vars) {
                    foreach ($dynamic_fields as $key => $value) {
                        $out['perch_' . $key] = $value;
                    }
                }
                $out = array_merge($dynamic_fields, $out);
            }
        }

        if (isset($out['eventSubjectData']) && $out['eventSubjectData'] != '') {
            $subject_fields = PerchUtil::json_safe_decode($out['eventSubjectData'], true);

            if (PerchUtil::count($subject_fields)) {
                if ($this->prefix_vars) {
                    foreach ($subject_fields as $key => $value) {
                        $out['subject_' . $key] = $value;
                    }
                }
                $out = array_merge($subject_fields, $out);
            }
        }

        return $out;
    }

    /**
     * Returns a formatted string for event type
     *
     * @return string
     */
    public function eventTypeFormatted()
    {
        return ucwords($this->eventType());
    }

    /**
     * Returns a formatted string for event action
     *
     * @return string
     */
    public function eventActionFormatted()
    {
        return ucwords(str_replace('_', ' ', $this->eventAction()));
    }

    /**
     * Returns formatted date
     *
     * @return string
     */
    public function eventTriggeredFormatted()
    {
        return DateTime::createFromFormat('Y-m-d H:i:s', $this->eventTriggered())->format('H:i:s d/m/Y');
    }

    /**
     * Retrieves nested subject id from serialized column
     *
     * @return int
     */
    public function eventSubjectID()
    {
        $details = $this->to_array();

        return $details['subject_id'];
    }

    /**
     * Retrieves nested subject title from serialized column
     *
     * @return string|null
     */
    public function eventSubjectTitle()
    {
        $details = $this->to_array();

        return $details['subject_title'];
    }

    /**
     * Retrieves nested subject content from serialized column
     *
     * @return string|null
     */
    public function eventSubjectContent()
    {
        $details = $this->to_array();

        return $details['subject_content'];
    }

    /**
     * Retrieves nested subject title from serialized column
     *
     * @return string|false
     */
    public function eventSubjectMedia()
    {
        $details = $this->to_array();

        return $details['subject_media'];
    }

    /**
     * Returns a list of past events matching the current
     *
     * @param bool|PerchPaging $Paging
     *
     * @return array|bool|SplFixedArray
     */
    public function history($Paging = false)
    {
        if ($this->eventSubjectID() == 0) {
            return false;
        }

        $sort_val = 'eventTriggered';
        $sort_dir = 'DESC';

        if ($Paging && $Paging->enabled()) {
            $sql = $Paging->select_sql();
            list($sort_val, $sort_dir) = $Paging->get_custom_sort_options();
        } else {
            $sql = 'SELECT';
        }

        $sql .= ' * FROM ' . $this->table . '
          WHERE (eventKey = ' . $this->db->pdb($this->eventKey()) . ' 
          AND eventSubjectID = ' . $this->db->pdb($this->eventSubjectID()) . ') 
          AND eventTriggered < ' . $this->db->pdb($this->eventTriggered());

        if ($sort_val) {
            $sql .= ' ORDER BY ' . $sort_val . ' ' . $sort_dir;
        } else {

            if (isset($this->default_sort_column)) {
                $sql .= ' ORDER BY ' . $this->default_sort_column . ' ' . $this->default_sort_direction;
            }
        }

        if ($Paging && $Paging->enabled()) {
            $sql .= ' ' . $Paging->limit_sql();
        }

        $result = $this->db->get_rows($sql);

        if ($Paging && $Paging->enabled()) {
            $Paging->set_total($this->db->get_count($Paging->total_count_sql()));
        }

        $Events = new RedFinchLogger_Events($this->api);

        return $Events->return_instances($result);
    }
}
