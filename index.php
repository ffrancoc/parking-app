<?php
require(__DIR__ . "/vendor/autoload.php");

use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use App\Controllers\DefaultController;
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Middlewares\SessionMiddleware;


$app = AppFactory::create();
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);


$twig = Twig::create("src/templates", ["cache" => false]);
$app->add(TwigMiddleware::create($app, $twig));
$app->add(SessionMiddleware::class . ':auth');

$app->get('/', DefaultController::class . ":index");
$app->get('/login', LoginController::class . ':get');
$app->post('/login', LoginController::class . ':post');
$app->get('/logout', LoginController::class . ':destroy');
$app->get('/home', [HomeController::class, 'get']);

$app->run();
