<?php

namespace Pletfix\Hello\Middleware;

use Core\Services\Contracts\Delegate;
use Core\Middleware\Contracts\Middleware as MiddlewareContract;
use Core\Services\Contracts\Request;

class Hello implements MiddlewareContract
{
    /**
     * @inheritdoc
     */
    public function process(Request $request, Delegate $delegate)
    {
        echo "Middleware 'Hello' - before<br/>";

        $response = $delegate->process($request);

        echo "Middleware 'Hello' - after<br/>";

        return $response;
    }
}
