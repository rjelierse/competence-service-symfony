<?php

use Sparse\AppKernel;
use Symfony\Component\HttpFoundation\Request;

require_once __DIR__ . '/../etc/autoload.php';

$environment = isset($_SERVER['SYMFONY_ENV']) ? $_SERVER['SYMFONY_ENV'] : 'dev';

$kernel = new AppKernel($environment, $environment === 'dev');
$kernel->loadClassCache();

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
