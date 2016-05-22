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
 * view.php entry script.
 *
 * @package   mod_php
 * @copyright 2016 Tomasz Muras  {@link https://leanpub.com/moodle}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("../../config.php");
require_once($CFG->dirroot . '/mod/php/locallib.php');

$id = required_param('id', PARAM_INT);  // Course Module ID.

list ($course, $cm) = get_course_and_cm_from_cmid($id, 'php');
$phpid = $cm->instance;

require_login($course, true, $cm);
require_capability("mod/php:grade",$cm->context);

// Get list of all expected user IDs.
$students = mod_php_students($cm->context);

// Get a grade for each of them.
$grades = array();
foreach($students as $student) {
    $grades[$student->id] = required_param('grade_' . $student->id, PARAM_INT);
}

// Update the database.
foreach ($grades as $userid => $grade) {
    mod_php_set_grade($phpid,$userid, $grade);
}

// Redirect back to the grading page.
redirect($CFG->wwwroot . "/mod/php/report.php?id=$id");