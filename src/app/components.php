<?php

use MyCodeLab\View\{View, Page};
use MyCodeLab\Database\Connection;
use MyCodeLab\Auth\Authentication;
use MyCodeLab\Foundation\{Application, Kernel};
use MyCodeLab\Http\{Request, Response, Session};
use MyCodeLab\Routing\{RouteMap, Factory as RouteFactory};


$app = new Application([
  'root'        => '../' . __DIR__,                       // ROOT
  'environment' => 'dev',                                 // APP_ENV
  'domain'      => 'http:localhost/myphpwebsiteuserauth', // DOMAIN_NAME
  'debug'       => true,                                  // DEBUG
  'timezone'    => 'America/Boise'                        // TIMEZONE
]);

$app->bind('kernel', function () use ($app) {
  return new Kernel($app);
});

$app->bind('url', function () {
  $url  = DOMAIN_NAME . DS;
  $url .= $_GET['path'] ?? null;
  $url .= $_SERVER['QUERY_STRING'] ?? null;
  
  return new Url($url);
});

$app->bind('request', function () use ($app) {  
  return Request::capture(
    $app->load('url')
  );
}, true);

$app->bind('response', function () {
  return new Response();
}, true);

$app->bind('session', function () {
  return new Session();
}, true);

// @todo: one of these objects will need a reference to $app
$app->bind('routeMap', function () {
  return new RouteMap(
    new RouteFactory()
  )
});

$app->bind('database', function () {
  return new Connection(DB_NAME, DB_USER, DB_PASS, DB_DRIVER, DB_HOST);
});

$app->bind('auth', function () use ($app) {
  $session = $app->load('session');
  return new Authentication($session);
});

$app->bind('view', function () {
  return new View();
});

$app->bind('page', function () {
  return new Page();
}, true);

// @todo: find a way to abstract
$app->bind('postsController', function () {
  $app->load('request'),
  $app->load('response'),
  $app->load('session'),
  $app->load('auth')
});

$app->bind('usersController', function () use ($app) {
  return new UsersController(
    $app->load('request'),
    $app->load('response'),
    $app->load('session'),
    $app->load('auth')
  );
});