<?php

namespace mod_php;
defined('MOODLE_INTERNAL') || die();

class observer {
    static public function grading(\mod_php\event\submission_graded $event) {
        global $DB;

        $supportuser = \core_user::get_support_user();
        $relateduser = $DB->get_record('user', array('id' => $event->relateduserid));
        email_to_user($supportuser, $relateduser, "Your PHP submission has been graded", "Hi " . fullname($relateduser) .
                " visit your Moodle site for the details.");
    }
}