<?php

namespace tvtandil\controllers\images;

use Silex\Application;
use \Silex\Api\ControllerProviderInterface;
use Doctrine\ORM\EntityManager;
use tvtandil\model\entities\Image;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use tvtandil\model\entities\tvtandil\model\entities;

class ImagesControllerProvider implements ControllerProviderInterface {
	public function connect(Application $app) {
		// creates a new controller based on the default route
		$controllers = $app ['controllers_factory'];
		
		$controllers->get ( '/{id}', function (Application $app, $id) {
			$imageRepository = $app ['orm.em']->getRepository ( 'tvtandil\model\entities\Image' );
			$image = $imageRepository->find ( $id );
			
			if ($image === null) {
				return new Response ( 404 );
			} else {
				ob_end_clean();
				
				$path = 'images/' . $image->getId() . '.jpg';
				
				return $app->sendFile($path, 200, array('Content-Type' => 'image/jpg'));
			}
		} );
		
		/* Allow OPTION method for all the used paths */
		$controllers->match ( '/{id}', function () {
			return new Response ( 200 );
		} )->method ( 'OPTIONS' );
		$controllers->match ( '/', function () {
			return new Response ( 200 );
		} )->method ( 'OPTIONS' );
		
		return $controllers;
	}
}