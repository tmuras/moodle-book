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
require_once($CFG->libdir . '/tablelib.php');

$id = required_param('id', PARAM_INT);  // Course Module ID.

$urlparams = array('id' => $id);

$url = new moodle_url('/mod/php/report.php', $urlparams);
list ($course, $cm) = get_course_and_cm_from_cmid($id, 'php');
$phpid = $cm->instance;

require_login($course, true, $cm);
require_capability("mod/php:grade",$cm->context);

$PAGE->set_url($url);

$table = new \flexible_table('mod-php-grading');

$columns = array();
$headers = array();

$columns[] = 'fullname';
$headers[] = get_string('name');
$columns[] = 'grade';
$headers[] = get_string('grade');

$table->define_columns($columns);
$table->define_headers($headers);
$table->define_baseurl($PAGE->url);

$students = mod_php_students($cm->context);

$tablehtml = '';
ob_start();
$table->setup();
foreach($students as $student) {
    $grade = mod_php_get_grade($phpid, $student->id);
    $form = html_writer::tag('input', NULL, ['id' => 'grade_'.$student->id, 'type' => 'text', 'name' => 'grade_'.$student->id, 'value'=>$grade]);
    $table->add_data([fullname($student), $form]);
}
$table->finish_output();

$tablehtml = ob_get_contents();
ob_clean();

$form = new mod_php_grading_form('report_post.php',['html'=>$tablehtml,'cm'=>$id]);

echo $OUTPUT->header();
$form->display();
echo $OUTPUT->footer();
