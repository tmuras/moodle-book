<?php

require_once("../../config.php");

$id = required_param('id', PARAM_INT);  // Course Module ID.
$name = optional_param('name', "anonymous", PARAM_TEXT);

$urlparams = array('id' => $id, 'name' => $name);

$url = new moodle_url('/mod/php/view.php', $urlparams);
list ($course, $cm) = get_course_and_cm_from_cmid($id, 'php');

require_login($course, true, $cm);
$PAGE->set_url($url);


echo $OUTPUT->header();
echo $OUTPUT->notification("Hello Module World, my name is $name.",'notifysuccess');
echo $OUTPUT->footer();
