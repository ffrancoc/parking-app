<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

use function PHPSTORM_META\type;

class LoginController
{
    static function get(Request $req, Response $res, array $args)
    {

        $data = [];
        $view = Twig::fromRequest($req);
        return $view->render($res, 'login.html', $data);
    }

    static function post(Request $req, Response $res, array $args)
    {

        $form = $req->getParsedBody();

        error_log(json_encode($form));

        $data = [];
        $view = Twig::fromRequest($req);

        $username = $form['username'];
        $password = $form['password'];
        $password_hash = hash('sha256', $password);

        $url = "http://localhost:8000/user/{$username}/{$password_hash}";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $cr = curl_exec($ch);
        $cr = json_decode($cr, true);
        curl_close($ch);


        if (count($cr['data']) > 0) {
            $data['user'] = $cr;
        } else {
            $data['error'] = 'Inicio de sesión inválido';
        }
        return $view->render($res, 'login.html', $data);
    }
}
