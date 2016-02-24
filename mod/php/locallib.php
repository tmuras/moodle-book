<?php
/**
 * Persist $submission in DB.
 */
function mod_php_save_submission($submission) {

}

/**
 * Get PHP submission for the current user (if exists).
 * @return stdClass
 */
function mod_php_get_my_submission() {
    $ret = new stdClass();
    $ret->id = 1;
    $ret->userid = 2;
    $ret->code = "echo 'Hello world';";
    $ret->title = "Sample title";

    return $ret;
}