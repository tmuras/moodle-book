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

/**
 * Get PHP submission for the given user (if exists).
 * @return stdClass
 */
function mod_php_get_user_submission($phpid, $userid) {
    global $DB;

    $submission = $DB->get_record('php_submissions', array('phpid' => $phpid, 'userid' => $userid));

    return $submission;
}

/**
 * Get submitted file.
 * @return stdClass
 */
function mod_php_get_user_file($contextid, $userid) {
    global $DB;

    $fs = get_file_storage();
    $files = $fs->get_area_files($contextid, 'mod_php', 'submission', $userid, NULL, false);

    if(!$files) {
        return false;
    }

    return current($files);
}

/**
 * Get PHP submission for the current user (if exists).
 * @return stdClass
 */
function mod_php_gradable_submission($phpid) {
    global $DB, $USER;

    $submissions = $DB->get_records('php_submissions', array('phpid' => $phpid, 'timegraded' => NULL));

    return $submissions;
}

/**
 * Get list of enrolled students.
 * @return stdClass
 */
function mod_php_students($context) {
    global $DB;

    $students = get_users_by_capability($context, array('mod/php:attempt'));

    return $students;
}

/**
 * Get current grade for a student in given PHP assignment.
 * @return stdClass
 */
function mod_php_get_grade($phpid, $userid) {
    global $DB;

    $submission = $DB->get_record('php_submissions', array('phpid' => $phpid, 'userid' => $userid));

    if($submission) {
        return $submission->grade;
    }

    return NULL;
}

/**
 * Set grade for a student in given PHP assignment.
 * @return stdClass
 */
function mod_php_set_grade($phpid, $userid, $grade) {
    global $DB;

    $submission = $DB->get_record('php_submissions', array('phpid' => $phpid, 'userid' => $userid));
    if($submission) {
        $submission->timegraded = time();
        $submission->grade = $grade;
        $DB->update_record('php_submissions', $submission);
    }
    return $submission;
}