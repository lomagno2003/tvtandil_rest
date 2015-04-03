<?php

namespace tvtandil\common\images;

use Silex\Application;
use tvtandil\model\entities\Image;

class ImageFactory{
	public function create(Application $app, $imageJSON){
		$newImage = new Image();
		$newImage->setEpigraph($imageJSON['epigraph']);
		
		$app['orm.em']->persist ( $newImage );
		$app['orm.em']->flush ();
		
		$path = 'images/' . $newImage->getId() . '.jpg';
		
		$explodedData = explode(',', $imageJSON['fileData']);
		$imageData = base64_decode($explodedData[1]);
		file_put_contents($path, $imageData);
		
		//TODO Configurar path
		$newImage->setUrl($path);
		
		$app['orm.em']->persist ( $newImage );
		$app['orm.em']->flush ();
		
		return $newImage;
	}
} 
