<?php

require_once('config.php');

$context = context_system::instance();
require_capability('moodle/user:viewdetails', $context);

$name = optional_param('name', "anonymous", PARAM_TEXT);

echo $OUTPUT->header();
echo $OUTPUT->notification("Hello World, my name is $name.");
echo $OUTPUT->footer();


