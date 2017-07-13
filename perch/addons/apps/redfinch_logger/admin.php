<?php

// Register app
$this->register_app('redfinch_logger', 'Logger', 5, 'Logs Perch system events for auditing purposes.', '1.0.1', !($CurrentUser->logged_in() && $CurrentUser->has_priv('redfinch_logger')));
$this->require_version('redfinch_logger', '3.0');

// Add settings
$this->add_setting('redfinch_logger_gc', 'Log lifetime', 'select', 90, [
    ['label' => '1 Month', 'value' => 30],
    ['label' => '3 Months', 'value' => 90],
    ['label' => '6 Months', 'value' => 180],
    ['label' => '1 Year', 'value' => 365]
], 'Records older than the selected value will be automatically deleted.');

// Autoloader
spl_autoload_register(function ($class_name) {

    if (strpos($class_name, 'RedFinchLogger_Type') === 0) {
        include(PERCH_PATH . '/addons/apps/redfinch_logger/lib/types/' . $class_name . '.php');

        return true;
    }

    if (strpos($class_name, 'RedFinchLogger') === 0) {
        include(PERCH_PATH . '/addons/apps/redfinch_logger/lib/' . $class_name . '.php');

        return true;
    }

    return false;
});

// Listeners
$API = new PerchAPI(1.0, 'redfinch_logger');

require __DIR__ . '/listeners/assets.php';
require __DIR__ . '/listeners/categories.php';
require __DIR__ . '/listeners/items.php';
require __DIR__ . '/listeners/regions.php';

if (PERCH_RUNWAY) {
    require __DIR__ . '/listeners/collections.php';
}
