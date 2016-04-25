<?php

use MyCodeLab\View\{View, Page};
use MyCodeLab\Database\Connection;
use MyCodeLab\Auth\Authentication;
use MyCodeLab\Foundation\{Application, Kernel};
use MyCodeLab\Http\{Request, Response, Session};
use MyCodeLab\Routing\{RouteMap, Factory as RouteFactory};


$app = new Application([
  'root'        => ROOT,
  'environment' => APP_ENV,
  'domain'      => DOMAIN_NAME,
  'debug'       => DEBUG, 
  'timezone'    => TIMEZONE
]);

$app->bind('database', function () {
  return new Connection(DB_NAME, DB_USER, DB_PASS, DB_DRIVER, DB_HOST);
});

$app->bind('session', function () {
  return new Session();
}, true);

$app->bind('auth', function () use ($app) {
  $session = $app->load('session');
  return new Authentication($session);
});

$app->bind('request', function () {
  return Request::capture();
}, true);

$app->bind('response', function () {
  return new Response();
}, true);

$app->bind('kernel', function () use ($app) {
  return new Kernel($app);
});

// @todo: one of these objects will need a reference to $app
$app->bind('routeMap', function () {
  return new RouteMap(
    new RouteFactory()
  )
});

$app->bind('view', function () {
  return new View();
});

$app->bind('page', function () {
  return new Page();
}, true);