<?php

$router = Core\Services\DI::getInstance()->get('router');

$router->get('hello-service', function() {
    return di('hello')->sayHello();
});

$router->get('hello', 'HelloController@index', 'Hello');
