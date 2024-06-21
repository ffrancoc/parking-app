<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;


class DefaultController
{

    static function index(Request $req, Response $res, array $args)
    {
        $data = [];
        $view = Twig::fromRequest($req);
        return $view->render($res, 'index.html', $data);
    }
}
