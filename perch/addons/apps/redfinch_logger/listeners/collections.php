<?php

$API->on('collection.publish_item', function(PerchSystemEvent $Event){
    $Dispatcher = new RedFinchLogger_Dispatcher(
        $Event->event,
        new RedFinchLogger_TypeCollection($Event->subject),
        $Event->user
    );

    $Dispatcher->save();
});
