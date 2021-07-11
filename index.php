<?php
require __DIR__ . '/vendor/autoload.php';
$bootstrap = new \Takomo\Core\Bootstrap(
    new \Takomo\Core\Request(),
    new \Takomo\Core\Response()
);
$bootstrap->execute();