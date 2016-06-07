<?php

class backup_php_activity_structure_step extends backup_activity_structure_step {

    protected function define_structure() {

        // To know if we are including userinfo
        $userinfo = $this->get_setting_value('userinfo');

        // Define each element separated
        $php = new backup_nested_element('php', array('id'), array(
            'name','timecreated','timemodified','grade'));

        $submissions = new backup_nested_element('submissions');
        $submission = new backup_nested_element('submission', array('id'), array(
            'userid','timecreated','title','code','grade','timegraded'));

        // Build the tree
        $php->add_child($submissions);
        $submissions->add_child($submission);

        // Define sources
        $php->set_source_table('php', array('id' => backup::VAR_ACTIVITYID));

        // All the rest of elements only happen if we are including user info
        if ($userinfo) {
            $submission->set_source_table('php_submissions', array('phpid' => backup::VAR_PARENTID));
        }

        // Define id annotations
        $submission->annotate_ids('user','userid');

        // Define file annotations
        $submission->annotate_files('mod_php', 'submission', 'userid');

        // Return the root element (php), wrapped into standard activity structure
        return $this->prepare_activity_structure($php);
    }
}