<?php

$Paging = $API->get('Paging');
$Paging->set_per_page('20');

// Data
$Users = new PerchUsers($API);
$Events = new RedFinchLogger_Events($API);

// default state
$filter = 'all';

// filters
if (isset($_GET['type']) && $_GET['type'] != '') {
    $filter = 'type';

    $Events->filterByType($_GET['type']);
}

if (isset($_GET['action']) && $_GET['action'] != '') {
    $filter = 'action';

    $Events->filterByAction($_GET['action']);
}

if (isset($_GET['user']) && $_GET['user'] != '') {
    $filter = 'user';

    $Events->filterByUser((int) $_GET['user']);
}

if (isset($_GET['show-filter']) && $_GET['show-filter']!='') {
    $filter = $_GET['show-filter'];
}

// Fetch
$events = $Events->all($Paging);
$users = $Users->all();

// Install app
if ($events === false) {
    $Events->attempt_install();
}
