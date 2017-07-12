<?php

if (!defined('PERCH_DB_PREFIX')) {
    exit;
}

$sql = "
CREATE TABLE `__PREFIX__redfinch_logger_events` (
    `eventID` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `eventKey` varchar(255) NOT NULL DEFAULT '',
    `eventType` varchar(255) NOT NULL DEFAULT '',
    `eventAction` varchar(255) NOT NULL DEFAULT '',
    `eventSubjectID` int(10) NOT NULL DEFAULT '0',
    `eventSubjectData` text,
    `eventUserID` int(10) NOT NULL DEFAULT '0',
    `eventTriggered` datetime NOT NULL,
    PRIMARY KEY (`eventID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
";

$sql = str_replace('__PREFIX__', PERCH_DB_PREFIX, $sql);

// Install
$statements = explode(';', $sql);
foreach ($statements as $statement) {
    $statement = trim($statement);
    if ($statement != '') {
        $this->db->execute($statement);
    }
}

// Permissions
$API = new PerchAPI(1.0, 'redfinch_logger');

$UserPrivileges = $API->get('UserPrivileges');
$UserPrivileges->create_privilege('redfinch_logger', 'Access the logger app');
//$UserPrivileges->create_privilege('redfinch_logger.clear', 'Clear the logger data');

// Settings
$Settings = $API->get('Settings');
$Settings->set('redfinch_logger_gc', 90);

// Installation check
$sql = 'SHOW TABLES LIKE "' . $this->table . '"';
$result = $this->db->get_value($sql);

return $result;
