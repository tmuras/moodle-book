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
 * Submit an assignment or edit the already submitted work
 *
 * @package    mod_php
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/lib/formslib.php');

class mod_php_submission_form extends moodleform
{

    function definition()
    {
        $mform = $this->_form;

        $mform->addElement('header', 'general', "Title header");

        $mform->addElement('text', 'title', "Title");
        $mform->setType('title', PARAM_TEXT);
        $mform->addRule('title', null, 'required', null, 'client');

        $choices = array('text', 'file');
        $default = 'text';
        $mform->addElement('select', 'format_choice', "Choose format", $choices);
        $mform->setDefault('format_choice', $default);
        $mform->setType('format_choice', PARAM_ALPHA);

        $mform->addElement('textarea', 'content_editor', "Paste your code", 'rows="20" cols="70"');
        $mform->setType('content_editor', PARAM_RAW);
        $mform->disabledIf('content_editor', 'format_choice', 'noteq', '0');

        $mform->addElement('static', 'filemanagerinfo', "Instead of pasting the code, you can choose " .
            "'file' format and attach a file below.");

        $mform->addElement('filemanager', 'attachment_filemanager', "Upload file here");
        $mform->disabledIf('attachment_filemanager', 'format_choice', 'noteq', '1');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $this->add_action_buttons();
    }

    function validation($data, $files)
    {
        global $USER;

        $errors = parent::validation($data, $files);

        $usercontext = context_user::instance($USER->id);
        $files = array();
        if (isset($data['attachment_filemanager'])) {
            $fs = get_file_storage();
            $files = $fs->get_area_files($usercontext->id, 'user', 'draft', $data['attachment_filemanager']);
        }

        // Make sure that either file or pasted code was submitted.
        if ((!empty($data['content_editor']) && count($files) > 1) ||
            (empty($data['content_editor']) && count($files) <= 1)
        ) {
            $errors['format_choice'] = 'Either submit a file or paste the code.';
        }

        return $errors;
    }
}
