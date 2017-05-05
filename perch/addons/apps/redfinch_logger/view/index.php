<?php

include(__DIR__ . '/../../../../core/inc/api.php');

// Permissions
if(!($CurrentUser->logged_in() && $CurrentUser->has_priv('redfinch_logger'))) {
    PerchUtil::redirect(PERCH_LOGINPATH);
}

// Perch API
$API = new PerchAPI(1.0, 'redfinch_logger');

// APIs
$Lang = $API->get('Lang');
$HTML = $API->get('HTML');
$Template = $API->get('Template');
$Settings = $API->get('Settings');

// Page settings
$Perch->page_title = $Lang->get('View Log');
$Perch->add_css($API->app_path() . '/assets/css/prism.css');
$Perch->add_css($API->app_path() . '/assets/css/redfinch_logger.css');
$Perch->add_javascript($API->app_path() . '/assets/js/prism-min.js');

// Page Initialising
include('../modes/_subnav.php');
include('../modes/logs.view.pre.php');

// Perch Frame
include(PERCH_CORE . '/inc/top.php');

// Page
include('../modes/logs.view.post.php');

// Perch Frame
include(PERCH_CORE . '/inc/btm.php');
