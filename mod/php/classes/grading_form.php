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
 * Submissions grading form.
 *
 * @package   mod_php
 * @copyright 2016 Tomasz Muras  {@link https://leanpub.com/moodle}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die('Direct access to this script is forbidden.');


require_once($CFG->libdir.'/formslib.php');

/**
 * mod_php grading form.
 *
 * @package   mod_php
 * @copyright 2016 Tomasz Muras  {@link https://leanpub.com/moodle}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_php_grading_form extends moodleform {
    /**
     * Define this form - called from the parent constructor
     */
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('html', $this->_customdata['html']);

        $mform->addElement('hidden', 'id', $this->_customdata['cm']);
        $mform->setType('id', PARAM_INT);

        $mform->addElement('submit', 'save', "Save");
    }
}

