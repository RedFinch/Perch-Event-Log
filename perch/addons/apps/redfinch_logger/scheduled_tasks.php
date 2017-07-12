<?php

PerchScheduledTasks::register_task('redfinch_logger', 'logger_events_gc', 1440, 'redfinch_logger_run_event_gc');

function redfinch_logger_run_event_gc($last_run_date)
{
    require __DIR__ . '/lib/RedFinchLogger_Events.php';
    require __DIR__ . '/lib/RedFinchLogger_Event.php';

    $API = new PerchAPI(1.0, 'redfinch_logger');

    $Settings = $API->get('Settings');
    $Events = new RedFinchLogger_Events($API);

    $days = $Settings->get('redfinch_logger_gc')->val();

    if(!$days) {
        return [
            'result' => 'FAILED',
            'message' => 'Please configure the length of time logs should be kept.'
        ];
    }

    $result = $Events->prune($days);

    if ($result) {
        return [
            'result'  => 'OK',
            'message' => 'Event logs have been pruned successfully.'
        ];
    } else {
        return [
            'result'  => 'OK',
            'message' => 'No logs were pruned.'
        ];
    }
};
