<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->mount('/news', new tvtandil\controllers\news\NewsControllerProvider());

return $app;