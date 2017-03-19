<?php

use Core\Testing\TestCase;

/**
 * HelloTest
 */
class HelloTest extends TestCase
{
    /**
     * Tests that it is possible to say hello
     */
    public function testPluginSaidHello()
    {
        $result = di('hello')->sayHello();
        $this->assertStringStartsWith('Hello', $result, 'The `Hello` plugin says not "Hello"!');
    }
}