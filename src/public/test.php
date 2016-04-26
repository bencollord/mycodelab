<?php

use MyCodeLab\Http\{Request, Response};
use MyCodeLab\System\NotFoundException;

require_once '../app/bootstrap.php';

$request  = Request::capture();
$response = new Response();

$response->write("ClassLibrary class is working with namespace change.")->send();