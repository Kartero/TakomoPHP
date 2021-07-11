<?php
require __DIR__ . '/vendor/autoload.php';

define('VIEW_PATH', __DIR__ . '/App/View');

$bootstrap = new \Takomo\Core\Bootstrap(
    new \Takomo\Core\Request(),
    new \Takomo\Core\Response()
);
$bootstrap->execute();