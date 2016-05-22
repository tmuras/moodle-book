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
 * view_submission.php entry script.
 *
 * @package   mod_php
 * @copyright 2016 Tomasz Muras  {@link https://leanpub.com/moodle}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("../../config.php");
require_once($CFG->dirroot . '/mod/php/locallib.php');

$id = required_param('id', PARAM_INT);  // Course Module ID.
$userid = required_param('userid', PARAM_INT);  // User ID.


$urlparams = array('id' => $id, 'userid' => $userid);

$url = new moodle_url('/mod/php/view_submission.php', $urlparams);
list ($course, $cm) = get_course_and_cm_from_cmid($id, 'php');
$phpid = $cm->instance;

require_login($course, true, $cm);
$PAGE->set_url($url);

// Permission check.
// You can only view submission if you can grade.
require_capability("mod/php:grade",$cm->context);

echo $OUTPUT->header();
$submission = mod_php_get_user_submission($phpid, $userid);
if($submission) {
    echo "PHP submission ".  $submission->title . "<br/>";
    echo "Submitted on  ". userdate($submission->timecreated) . "<br/>";
    if($submission->timegraded) {
        echo "Graded: ". $submission->grade . " on " . userdate($submission->timegraded) . "<br/>";
    }

    // Only dislpay code submitted in the form, we do not know how to handle files yet.
    echo "<pre>" . $submission->code . "</pre>";
}
echo $OUTPUT->footer();
