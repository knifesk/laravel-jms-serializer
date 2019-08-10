<?php

use JMS\Serializer\EventDispatcher\EventDispatcher;
use JMS\Serializer\Handler\HandlerRegistry;

return [
    'default_handlers' => true,

    'event_listeners' => [
        function (EventDispatcher $dispatcher) {
            //$dispatcher->addSubscriber(new SampleSubscriber());
        }
    ],

    'handlers' => [
        function (HandlerRegistry $registry) {
            //$registry->registerSubscribingHandler(new UuidSerializerHandler());
        }
    ],

    'paths' => [
        '' => './'
    ],

    'cache_dir' => storage_path('serializer'),
];
