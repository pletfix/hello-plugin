<?php

namespace Pletfix\Hello\Controllers;

class HelloController
{
    public function index()
    {
        return view('hello.welcome');
    }
}