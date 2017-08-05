<?php

// Title panel
echo $HTML->title_panel([
    'heading' => $Lang->get('View Logs')
], $CurrentUser);

// Smart bar
$Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

$Smartbar->add_item([
    'active' => $filter === 'all',
    'title'  => 'All',
    'link'   => '/addons/apps/redfinch_logger/'
]);

$Smartbar->add_item([
    'id'      => 'etf',
    'title'   => 'Type',
    'icon'    => 'core/o-signs',
    'active'  => PerchRequest::get('type'),
    'type'    => 'filter',
    'arg'     => 'type',
    'options' => array_map(function ($item) {
        return ['value' => $item, 'title' => ucfirst($item)];
    }, $Events->getEventTypes()),
    'actions' => []
]);

$Smartbar->add_item([
    'id'      => 'eaf',
    'title'   => 'Action',
    'icon'    => 'core/o-tag',
    'active'  => PerchRequest::get('action'),
    'type'    => 'filter',
    'arg'     => 'action',
    'options' => array_map(function ($item) {
        return ['value' => $item, 'title' => ucfirst(str_replace('_', ' ', $item))];
    }, $Events->getEventActions()),
    'actions' => []
]);

if (PerchUtil::count($users)) {
    $filter_opts = [];

    foreach ($users as $user) {
        $filter_opts[] = [
            'value' => $user->id(),
            'title' => $user->userUsername()
        ];
    }

    $Smartbar->add_item([
        'id'      => 'euf',
        'title'   => 'User',
        'icon'    => 'core/user',
        'active'  => PerchRequest::get('user'),
        'type'    => 'filter',
        'arg'     => 'user',
        'options' => $filter_opts,
        'actions' => []
    ]);
}

echo $Smartbar->render();

// Listing
$Listing = new PerchAdminListing($CurrentUser, $HTML, $Lang, $Paging);

$Listing->add_col([
    'title'     => 'Date / Time',
    'value'     => 'eventTriggeredFormatted',
    'sort'      => 'eventTriggered',
    'edit_link' => 'view',
]);

$Listing->add_col([
    'title' => 'User',
    'value' => function ($event) use ($users) {
        $user = array_filter($users, function ($item) use ($event) {
            return $item->id() === $event->eventUserID();
        });

        if(PerchUtil::count($user)) {
            $user = array_values($user)[0];

            return $user->userUsername();
        }

        return 'admin';
    },
    'gravatar'  => function($event) use ($users) {
        $user = array_filter($users, function ($item) use ($event) {
            return $item->id() === $event->eventUserID();
        });

        if(PerchUtil::count($user)) {
            $user = array_values($user)[0];

            return $user->userEmail();
        }

        return '';
    }
]);

$Listing->add_col([
    'title' => 'Type',
    'value' => 'eventTypeFormatted'
]);

$Listing->add_col([
    'title' => 'Action',
    'value' => 'eventActionFormatted'
]);

$Listing->add_col([
    'title' => 'Subject',
    'value' => 'eventSubjectTitle'
]);

//$Listing->add_delete_action([
//    'priv'   => 'redfinch_logger.clear',
//    'inline' => true,
//    'path'   => 'delete',
//]);

echo $Listing->render($events);
