<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * API functions implementation for mod_php.
 *
 * @package   mod_php
 * @copyright 2015 Tomasz Muras  {@link https://leanpub.com/moodle}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Add PHP module instance.
 *
 * @param stdClass $data
 * @param stdClass $mform
 * @return int new book instance id
 */
function php_add_instance($data, $mform) {
    global $DB;

    $data->timecreated = time();
    $data->timemodified = $data->timecreated;

    $data->id = $DB->insert_record('php', $data);

    // Update grade item definition.
    php_grade_item_update($data);

    return $data->id;
}

/**
 * Given an object containing all the necessary data,
 * (defined by the form in mod_form.php) this function
 * will update an existing instance with new data.
 *
 * @global object
 * @param object $php
 * @return bool
 */
function php_update_instance($php) {
    global $DB;

    $php->id = $php->instance;
    $php->timemodified = time();

    $DB->update_record("php", $php);

    // Update grade item definition.
    php_grade_item_update($php);

    // Update grades.
    php_update_grades($php, 0, false);

    return true;
}


/**
 * Return the list of Moodle features this module supports.
 *
 * @param string $feature FEATURE_xx constant for requested feature
 * @return mixed True if module supports feature, null if doesn't know
 */
function php_supports($feature) {
    switch ($feature) {
        case FEATURE_MOD_INTRO:
            return false;
        case FEATURE_GRADE_HAS_GRADE:
            return true;
        default:
            return null;
    }
}

function php_grade_item_update($php, $grades = null) {
    global $CFG;
    require_once($CFG->libdir . '/gradelib.php');

    $params['gradetype'] = GRADE_TYPE_VALUE;
    $params['grademax'] = 100;
    $params['grademin'] = 0;
    return grade_update('mod/php', $php->course, 'mod', 'php', $php->id, 0, $grades, $params);
}

/**
 * Update grades in central gradebook
 *
 * @category grade
 * @param object $php
 * @param int $userid specific user only, 0 means all
 * @param bool $nullifnone
 */
function php_update_grades($php, $userid = 0, $nullifnone = true) {
    global $CFG, $DB;
    require_once($CFG->libdir . '/gradelib.php');

    $grades = null;
    if ($userid) {
        $grades = array();
        $grade = mod_php_get_grade($php->id, $userid);
        $grades[$userid] = ['userid' => $userid, 'rawgrade' => $grade];
    }
    php_grade_item_update($php, $grades);
}