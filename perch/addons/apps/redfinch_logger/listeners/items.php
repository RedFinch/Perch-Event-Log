<?php

$API->on('item.delete', function(PerchSystemEvent $Event){

    if(PERCH_RUNWAY && $Event->subject instanceof PerchContent_CollectionItem) {
        $subject = new RedFinchLogger_TypeCollection($Event->subject);
    } else {
        $subject = new RedFinchLogger_TypeItem($Event->subject);
    }

    $Dispatcher = new RedFinchLogger_Dispatcher($Event->event, $subject, $Event->user);

    $Dispatcher->save();
});
