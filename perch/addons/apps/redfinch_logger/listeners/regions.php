<?php

foreach(['region.truncate', 'region.share', 'region.unshare', 'region.undo', 'region.publish', 'region.delete'] as $eventKey) {
    $API->on($eventKey, function(PerchSystemEvent $Event){
        $Dispatcher = new RedFinchLogger_Dispatcher(
            $Event->event,
            new RedFinchLogger_TypeRegion($Event->subject),
            $Event->user
        );

        $Dispatcher->save();
    });
}
