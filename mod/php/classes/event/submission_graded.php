<?php

namespace mod_php\event;
defined('MOODLE_INTERNAL') || die();

class submission_graded extends \core\event\base {
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
        $this->data['objecttable'] = 'php';
    }

    public function get_description() {
        return "The user with id '$this->userid' has graded the submission '$this->objectid' for the user with " .
        "id '$this->relateduserid' for the assignment with course module id '$this->contextinstanceid'.";
    }

    public static function get_name() {
        return get_string('eventsubmissiongraded', 'mod_php');
    }
}

