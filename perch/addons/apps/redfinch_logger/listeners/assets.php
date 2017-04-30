<?php

$API->on('assets.upload_image', function(PerchSystemEvent $Event){
    $Dispatcher = new RedFinchLogger_Dispatcher(
        $Event->event,
        new RedFinchLogger_TypeAsset($Event->subject),
        $Event->user
    );

    $Dispatcher->save();
});
