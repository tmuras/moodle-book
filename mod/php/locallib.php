<?php
/**
 * Persist $submission in DB.
 */
function mod_php_save_submission($submission) {
    global $DB, $USER;

    $submission->userid = $USER->id;
    $submission->timecreated = time();

    return $DB->insert_record('php_submissions',$submission);
}

/**
 * Get PHP submission for the current user (if exists).
 * @return stdClass
 */
function mod_php_get_my_submission($phpid) {
    global $DB, $USER;

    $submission = $DB->get_record('php_submissions', array('phpid' => $phpid, 'userid' => $USER->id));

    return $submission;
}