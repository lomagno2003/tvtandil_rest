<?php

namespace tvtandil\controllers\news;

use Silex\Application;
use \Silex\Api\ControllerProviderInterface;
use Doctrine\ORM\EntityManager;
use tvtandil\model\entities\News;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use tvtandil\model\entities\tvtandil\model\entities;
use tvtandil\common\images\ImageFactory;
use tvtandil\common\socialmedia\TwitterAdapter;
use tvtandil\model\entities\SocialMediaReference;
use tvtandil\common\socialmedia\FacebookAdapter;
use tvtandil\common\socialmedia\CompositeSocialMediaAdapter;
use tvtandil\common\video\VideoFactory;
use tvtandil\common\socialmedia\ISocialMediaAdapter;
use tvtandil\common\socialmedia\tvtandil\common\socialmedia;
use tvtandil\common\video\tvtandil\common\video;

class NewsControllerProvider implements ControllerProviderInterface {
	private $socialMediaAdapter;

	public function connect(Application $app) {
		$this->socialMediaAdapter = new CompositeSocialMediaAdapter(new TwitterAdapter($app));
		
		// creates a new controller based on the default route
		$controllers = $app ['controllers_factory'];
		
		$controllers->get ( '/', function (Application $app) {
			$result = array ();
			
			$newsRepository = $app ['orm.em']->getRepository ( 'tvtandil\model\entities\News' );
			
			$products = $newsRepository->findAll ();
			
			return json_encode($products);
		} );
		
		$controllers->get ( '/{id}', function (Application $app, $id) {
			$newsRepository = $app ['orm.em']->getRepository ( 'tvtandil\model\entities\News' );
			$news = $newsRepository->find ( $id );
			
			if ($news === null) {
				return new Response ( 404 );
			} else {
				return json_encode($news);
			}
		} );
		
		$controllers->post ( '/', function (Application $app, Request $request) {
			$data = json_decode ( $request->getContent (), true );
			
			$news = new News ();
			$news->setTitle ( $data ['title'] );
			$news->setDescription ( $data ['description'] );
			
			if ($data ['labels']) {
				foreach ( $data ['labels'] as $label ) {
					$labelRepository = $app ['orm.em']->getRepository ( 'tvtandil\model\entities\Label' );
					$labelEntity = $labelRepository->find ( $label );
					if ($labelEntity === null) {
						return new Response ( "Unknow Label " . $label, 500 );
					} else {
						$news->getLabels ()->add ( $labelEntity );
					}
				}
			}
			
			$app ['orm.em']->persist ( $news );
			
			if ($data ['media']) {
				foreach ( $data ['media'] as $media ) {
					if ($media ['type'] == 'NEW_IMAGE') {
						$imageFactory = new ImageFactory ();
						$image = $imageFactory->create ( $app, $media, $news );
					}
					if ($media ['type'] == 'UPLOADED_VIDEO') {
						$videoFactory = new VideoFactory();
						$video = $videoFactory->createFromUploadedVideo( $app, $media, $news );
					}
				}
			}

			$this->socialMediaAdapter->post($news);
			
			$app ['orm.em']->persist ( $news );
			$app ['orm.em']->flush ();
			
			return new Response ( $news->getId(), 200 );
		} );
		
		$controllers->put ( '/{id}', function (Application $app, Request $request, $id) {
			$data = json_decode ( $request->getContent (), true );
			
			$newsRepository = $app ['orm.em']->getRepository ( 'tvtandil\model\entities\News' );
			$news = $newsRepository->find ( $id );
			
			if ($news === null) {
				return new Response ( 404 );
			} else {
				$news->setTitle ( $data ['title'] );
				$app ['orm.em']->flush ();
				return new Response ( 200 );
			}
		} );
		
		$controllers->delete ( '/{id}', function (Application $app, Request $request, $id) {
			$data = json_decode ( $request->getContent (), true );
			
			$newsRepository = $app ['orm.em']->getRepository ( 'tvtandil\model\entities\News' );
			$news = $newsRepository->find ( $id );
			
			
			if ($news === null) {
				return new Response ( 404 );
			} else {
				$this->socialMediaAdapter->delete($news);
				
				$app ['orm.em']->remove ( $news );
				$app ['orm.em']->flush ();
				return new Response ( 200 );
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