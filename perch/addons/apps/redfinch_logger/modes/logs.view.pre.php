<?php

if (isset($_GET['id']) && $_GET['id'] != '') {
    $eventID = (int) $_GET['id'];
} else {
    PerchUtil::redirect($API->app_path() . '/');
}

// Paging
$Paging = $API->get('Paging');
$Paging->set_per_page('5');

// Default
$event = false;
$user = false;
$history= false;

$activeSection = 'default';

// Data
$Users = new PerchUsers($API);
$Events = new RedFinchLogger_Events($API);

$event = $Events->find($eventID);
$history = $event->history($Paging);

// Check event exists
if(!$event) {
    PerchUtil::redirect($API->app_path() . '/');
}

// Find user
if($event->eventUserID()) {
    $users = $Users->all();

    $user = array_filter($users, function($item) use($event) {
        return $item->id() === $event->eventUserID();
    });

    if(PerchUtil::count($user)) {
        $user = array_values($user)[0];
    }
}

// History
if(isset($_GET['section']) && $_GET['section'] === 'history') {
    $activeSection = 'history';

    $Template->set_from_string('<perch:logger id="subject_content" />', 'logger');

    require(__DIR__ . '/../lib/htmldiff/html_diff.php');
}
