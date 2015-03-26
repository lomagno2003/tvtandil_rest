<?php

/* DOCTRINE SETUP */
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once __DIR__.'/../vendor/autoload.php';

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/../src/model"), $isDevMode);

// database configuration parameters
$connectionOptions = array(
		'driver'   => 'pdo_mysql',
		'host'     => '127.0.0.1',
		'dbname'   => 'tvtandil',
		'user'     => 'root',
		'password' => 'root'
);

// obtaining the entity manager
$entityManager = EntityManager::create($connectionOptions, $config);

return $entityManager;