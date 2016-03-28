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

$arr = [];
$count = count($arr);

for ($i = 0; $i < $count; ++$i) {
  $arr[$i] = $arr[$i] * 3;
  echo $arr[$i];
}
