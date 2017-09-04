<?php

$di = \Core\Services\DI::getInstance();

$di->set('hello', \Pletfix\Hello\HelloService::class, true);
