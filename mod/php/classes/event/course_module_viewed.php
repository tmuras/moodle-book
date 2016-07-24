<?php

namespace mod_php\event;
defined('MOODLE_INTERNAL') || die();

class course_module_viewed extends \core\event\course_module_viewed {
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'php';
    }
}