<?php
/**
 * Persist $submission in DB.
 */
function mod_php_save_submission($submission) {
    global $DB;
    // $DB->insert_record('')
}

/**
 * Get PHP submission for the current user (if exists).
 * @return stdClass
 */
function mod_php_get_my_submission() {
    global $DB, $USER;

    $submission = $DB->get_records('php_submissions',array());

    return $submission;
}