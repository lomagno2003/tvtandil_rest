<?php

namespace tvtandil\controllers\news;

use Silex\Application;
use \Silex\Api\ControllerProviderInterface;
use Doctrine\ORM\EntityManager;
use tvtandil\model\entities\News;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NewsControllerProvider implements ControllerProviderInterface {
	public function connect(Application $app) {
		// creates a new controller based on the default route
		$controllers = $app ['controllers_factory'];
		
		$controllers->get ( '/', function (Application $app) {
			$result = array ();
			
			$newsRepository = $app ['orm.em']->getRepository ( 'tvtandil\model\entities\News' );
			
			$products = $newsRepository->findAll ();
			
			foreach ( $products as $product ) {
				array_push ( $result, $product );
			}
			
			return $app ['serializer']->serialize ( $result, 'json' );
		} );
		
		$controllers->put ( '/{id}', function (Application $app, Request $request, $id) {
			$data = json_decode($request->getContent(), true);
			
			$newsRepository = $app ['orm.em']->getRepository ( 'tvtandil\model\entities\News' );
			$news = $newsRepository->find ( $id );
			
			$news->setTitle ( $data['title']);
			$app ['orm.em']->flush();
			return new Response ( 200 );
		} );
		
		$controllers->match('/{id}', function(){
			return new Response ( 205 );
		})->method('OPTIONS');
		
		return $controllers;
	}
}