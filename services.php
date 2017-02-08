<?php

$di = \Core\Services\DI::getInstance();

/*
 * Singleton Instance (shared)
 */

$di->set('hello', \Pletfix\Hello\HelloService::class, true);

/*
 * Multiple Instance (not shared)
 */