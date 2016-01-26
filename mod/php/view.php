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
 * @copyright 2015 Tomasz Muras  {@link https://leanpub.com/moodle}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("../../config.php");

$id = required_param('id', PARAM_INT);  // Course Module ID.

$urlparams = array('id' => $id, 'name' => $name);

$url = new moodle_url('/mod/php/view.php', $urlparams);
list ($course, $cm) = get_course_and_cm_from_cmid($id, 'php');

require_login($course, true, $cm);
$PAGE->set_url($url);


echo $OUTPUT->header();
echo $OUTPUT->notification("This is PHP assignment. Stay tuned!",'notifysuccess');
echo $OUTPUT->footer();
