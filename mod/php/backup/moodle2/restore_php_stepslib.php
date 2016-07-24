<?php
/**
 * Structure step to restore one choice activity
 */
class restore_php_activity_structure_step extends restore_activity_structure_step {

    protected function define_structure() {

        $paths = array();
        $userinfo = $this->get_setting_value('userinfo');

        $paths[] = new restore_path_element('php', '/activity/php');
        if ($userinfo) {
            $paths[] = new restore_path_element('php_submissions', '/activity/php/submissions/submission');
        }

        // Return the paths wrapped into standard activity structure
        return $this->prepare_activity_structure($paths);
    }

    protected function process_php($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;
        $data->course = $this->get_courseid();

        $data->timecreated = $this->apply_date_offset($data->timecreated);
        $data->timemodified = $this->apply_date_offset($data->timemodified);

        // insert the record into DB
        $newitemid = $DB->insert_record('php', $data);

        // immediately after inserting "activity" record, call this
        $this->apply_activity_instance($newitemid);
    }

    protected function process_php_submissions($data) {
        global $DB;

        $data = (object)$data;

        $data->phpid = $this->get_new_parentid('php');
        $data->userid = $this->get_mappingid('user', $data->userid);
        $data->timecreated = $this->apply_date_offset($data->timecreated);
        $data->timegraded = $this->apply_date_offset($data->timegraded);

        $newitemid = $DB->insert_record('php_submissions', $data);
    }

    protected function after_execute() {
        $this->add_related_files('mod_php', 'submission', null);
    }

}