<?php

$route = \Core\Application::route();

$route->get('hello-service', function() {
    return di('hello')->sayHello();
});

$route->get('hello', 'HelloController@index', 'Hello');
