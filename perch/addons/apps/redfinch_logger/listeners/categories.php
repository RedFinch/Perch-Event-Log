<?php

foreach(['category.create', 'category.update'] as $eventKey) {
    $API->on($eventKey, function(PerchSystemEvent $Event){
        $Dispatcher = new RedFinchLogger_Dispatcher(
            $Event->event,
            new RedFinchLogger_TypeCategory($Event->subject),
            $Event->user
        );

        $Dispatcher->save();
    });
}
