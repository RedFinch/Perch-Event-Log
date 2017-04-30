<?php

$API->on('item.delete', function(PerchSystemEvent $Event){
    $Dispatcher = new RedFinchLogger_Dispatcher(
        $Event->event,
        new RedFinchLogger_TypeItem($Event->subject),
        $Event->user
    );

    $Dispatcher->save();
});
