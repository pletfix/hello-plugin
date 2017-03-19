<?php

$route = \Core\Application::route();

$route->get('hello', function() {
    return di('hello')->sayHello();
//  return view('test2', $data = collect(['name' => 'Anton']));
});
