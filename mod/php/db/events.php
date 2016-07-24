<?php
$observers = array(
    array(
        'eventname'   => '\mod_php\event\submission_graded',
        'callback'    => '\mod_php\observer::grading',
    ),
);