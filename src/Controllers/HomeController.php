<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class HomeController
{

    static function get(Request $req, Response $res, array $args): Response
    {
        $session = empty(!$_SESSION['user_id']);
        $data = [
            'session' => $session
        ];

        if (!$session) {
            return $res->withHeader('Location', '/login')->withStatus(302);
        }


        $view = Twig::fromRequest($req);
        return $view->render($res, 'home.html', $data);
    }
}
