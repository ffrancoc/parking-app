<?php

declare(strict_types=1);

namespace App\Middlewares;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Psr\Http\Message\ResponseInterface as Response;

class SessionMiddleware
{
    static function auth(Request $req, Handler $handler): Response
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $res = $handler->handle($req);
        return $res;
    }
}
