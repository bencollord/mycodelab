<?php

require_once 'bootstrap.php';

use App\Post;
use Lib\View\Grid\GridView;
//
//$posts = Post::loadAll('public');
//
//$grid = new GridView();
//
//$columns = ['id', 'details', 'postTime', 'editTime'];
//
//$grid->bind($posts, $columns);

$params = ['one', 'two', 'red', 'blue'];

foreach ($params as $p) {
  $p .= ' fish';
}

foreach ($params as $p) {
  echo $p . '<br />';
}
