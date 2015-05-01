<?php

namespace tvtandil\common\images;

use Silex\Application;
use tvtandil\model\entities\Image;

class ImageFactory{
	public static function getImagePath(Image $image){
		return 'images/' . $image->getId() . '.jpg';
	}
	
	public function create(Application $app, $imageJSON, $news){
		$newImage = new Image();
		$newImage->setEpigraph($imageJSON['epigraph']);
		$newImage->setNews($news);
		
		$app['orm.em']->persist ( $newImage );
		$app['orm.em']->flush ();
		
		$path = ImageFactory::getImagePath($newImage);
		
		$explodedData = explode(',', $imageJSON['fileData']);
		$imageData = base64_decode($explodedData[1]);
		file_put_contents($path, $imageData);
		
		//TODO Configurar path
		$newImage->setUrl(APP_BASE_URL . 'images/' . $newImage->getId());
		
		$app['orm.em']->persist ( $newImage );
		$app['orm.em']->flush ();
		
		return $newImage;
	}
} 
