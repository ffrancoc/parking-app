<?php

declare(strict_types=1);

namespace App\Controllers;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;
use GuzzleHttp\Client;


class LoginController
{

    static Client $client;

    static function get(Request $req, Response $res, array $args): Response
    {
        $session = empty(!$_SESSION['user_id']);

        $data = [
            'session' => $session
        ];
        $view = Twig::fromRequest($req);
        return $view->render($res, 'login.html', $data);
    }

    static function post(Request $req, Response $res, array $args): Response
    {

        $form = $req->getParsedBody();
        $data = [];
        $view = Twig::fromRequest($req);

        $username = $form['username'];
        $password = $form['password'];
        $password_hash = hash('sha256', $password);

        $url = "http://localhost:8000/user/{$username}/{$password_hash}";

        $client = new Client();
        $request = $client->request('GET', $url);

        $resp = json_decode($request->getBody()->__toString(), true);

        if (count($resp['data']) > 0) {
            $_SESSION['user_id'] = $resp['data']['id'];
            return $res->withHeader('Location', '/home')->withStatus(302);
        } else {
            $data['error'] = 'Usuario inválido';
        }
        return $view->render($res, 'login.html', $data);
    }

    static function destroy(Request $req, Response $res): Response
    {
        session_destroy();
        return $res->withHeader('Location', '/login')->withStatus(302);
    }
}
