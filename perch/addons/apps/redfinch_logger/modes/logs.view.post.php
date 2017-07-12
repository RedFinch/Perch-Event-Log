<?php

// Title
echo $HTML->title_panel([
    'heading' => $Lang->get('Details'),
], $CurrentUser);

// Smart bar
$Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

$Smartbar->add_item([
    'active' => $activeSection === 'default',
    'title'  => 'Latest',
    'link'   => '/addons/apps/redfinch_logger/view/?id=' . $event->id(),
    'icon' => 'core/document'
]);

if(PerchUtil::count($history)) {
    $Smartbar->add_item([
        'active' => $activeSection === 'history',
        'title'  => 'History',
        'link'   => '/addons/apps/redfinch_logger/view/?id=' . $event->id() . '&section=history',
        'icon'   => 'core/clock'
    ]);
}

echo $Smartbar->render();

?>

<?php switch($activeSection) {
    case 'history':
        require __DIR__ . '/partials/history.php';
        break;
    case 'default':
    default:
        require __DIR__ . '/partials/overview.php';
        break;
} ?>
