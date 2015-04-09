<?php
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/constants.php';

use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\SerializerServiceProvider;

// scheme required, here can be multiple origins concatenated by space if using credentials
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Accept, X-Requested-With, Content-Type');
// without credentials we can use * for origin
header('Access-Control-Allow-Credentials: true');
header('HTTP/1.1 200 OK', true);

$app = new Silex\Application();

$app['debug'] = true;
$app->register(new DoctrineServiceProvider, array(
    "db.options" => array(
		'driver'   => 'pdo_mysql',
		'host'     => '127.0.0.1',
		'dbname'   => 'tvtandil',
		'user'     => 'root',
		'password' => 'root')
));

$app->register(new DoctrineOrmServiceProvider, array(
		"orm.em.options" => array(
				"mappings" => array(
						// Using actual filesystem paths
						array(
								"type" => "annotation",
								"namespace" => "tvtandil\\model\\entities",
								"path" => __DIR__."../src",
						)
				)
		),
		"orm.proxies_dir" => "../cache/doctrine/proxies"
));
// $app ['orm.em']->setProxyDir(__DIR__ . "../cache/doctrine/proxies");

$app->register(new SerializerServiceProvider());

$app->mount('/news', new tvtandil\controllers\news\NewsControllerProvider());
$app->mount('/images', new tvtandil\controllers\images\ImagesControllerProvider());

return $app;