<?php

namespace tvtandil\controllers\news;

use Silex\Application;
use \Silex\Api\ControllerProviderInterface;

class NewsControllerProvider implements ControllerProviderInterface{
	public function connect(Application $app) {
		// creates a new controller based on the default route
		$controllers = $app ['controllers_factory'];
		
		$controllers->get ( '/', function (Application $app) {
			return 'Hello World';
        });

        return $controllers;
    }
}