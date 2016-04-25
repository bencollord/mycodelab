<?php

use MyCodeLab\Foundation\Application;
use MyCodeLab\System\ClassLibrary;


require_once '../lib/System/ClassLibrary.php';

$framework = new ClassLibrary('MyCodeLab', 'lib');
$appCode   = new ClassLibrary('MyPhpWebsiteUserAuth', 'app');

$framework->register();
$appCode->register();