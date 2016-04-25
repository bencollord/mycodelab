<?php

use MyCodeLab\Foundation\RouteMap;

$map = new RouteMap();

$routes = [
  '/'                      => 'Posts:home',
  '/login'                 => 'Users:login',
  '/logout'                => 'Users:logout',
  '/signup'                => 'Users:register',
  '/posts/add'             => 'Posts:add',
  '/posts/<id:\d+>/edit'   => 'Posts:edit',
  '/posts/<id:\d+>/delete' => 'Posts:delete'
];

$map->register('/test', function () {
  return (new Response())->write('Closure routing works!');
});

