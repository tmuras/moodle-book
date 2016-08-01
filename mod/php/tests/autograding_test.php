<?php

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/mod/php/locallib.php');

class autograding_testcase extends advanced_testcase {
    public function test_auto_grade_result() {
        $mocksubmission = new stdClass();
        $this->assertFalse(mod_php_check_submission($mocksubmission));
    }
}