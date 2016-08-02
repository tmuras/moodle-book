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
require_once($CFG->dirroot . '/mod/php/locallib.php');

$id = required_param('id', PARAM_INT);  // Course Module ID.

$urlparams = array('id' => $id);

$url = new moodle_url('/mod/php/view.php', $urlparams);
list ($course, $cm) = get_course_and_cm_from_cmid($id, 'php');
$phpid = $cm->instance;

require_login($course, true, $cm);
$PAGE->set_url($url);

// Mark as viewed.
$completion = new completion_info($course);
$completion->set_module_viewed($cm);

echo $OUTPUT->header();

$mform = new mod_php_submission_form();
$submission = mod_php_get_my_submission($phpid);
if ($mform->is_cancelled()) {
    // Form cancelled, redirect.
    redirect(new moodle_url('view.php', array()));
    return;
} else if (($data = $mform->get_data())) {
    // Form has been submitted.
    $draftitemid = file_get_submitted_draft_itemid('attachment_filemanager');
    file_save_draft_area_files($draftitemid, $cm->context->id, 'mod_php', 'submission', $USER->id);
    $data->phpid = $phpid;
    $data->code = $data->content_editor;
    mod_php_save_submission($data);
} else {
    // Form has not been submitted or there was an error, just display.
    $mform->set_data(array('id' => $id));
    if ($submission) {
        $draftitemid = 0;
        file_prepare_draft_area($draftitemid, $cm->context->id, 'mod_php', 'submission', $USER->id);
        $mform->set_data(array('content_editor' => $submission->code,
            'title' => $submission->title, 'attachment_filemanager' => $draftitemid));
    }
    $mform->display();
}

echo $OUTPUT->notification("This is PHP assignment. Stay tuned!", 'notifysuccess');
echo $OUTPUT->footer();
