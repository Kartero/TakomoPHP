<?php

use Takomo\Core\Autowire;
use Takomo\Core\Bootstrap;

require __DIR__ . '/vendor/autoload.php';

define('ROOT_PATH', __DIR__);
define('VIEW_PATH', __DIR__ . '/App/View');
define('LOG_PATH', __DIR__ . '/tmp/logs');
define('BASE_URL', 'http://' . $_SERVER['SERVER_NAME']);

$autowire = new Autowire();
$bootstrap = $autowire->di(Bootstrap::class);
//\Takomo\Core\Config::loadConfig();
/*$bootstrap = new \Takomo\Core\Bootstrap(
    new \Takomo\Core\Request(),
    new \Takomo\Core\Response()
);*/
$bootstrap->execute();