<?php

namespace tvtandil\common\video;

use Silex\Application;
use tvtandil\model\entities\Image;
use Google_Client;
use Google_Service_YouTube;
use Google_Service_YouTube_VideoSnippet;
use Google_Service_YouTube_VideoStatus;
use Google_Service_YouTube_Video;
use tvtandil\model\entities\Video;

class VideoFactory {
	public function create(Application $app, $videoJSON) {
		$client_id = "188975889831-gjrepu1med1vqbj57jolblcdob3lmlfd.apps.googleusercontent.com";
		$client_secret = "660cef80563f66fb1f4e3718779bacde56ed418d";
		
		$client = new Google_Client ();
		
// 		$client->setApplicationName("tvtandil");
// 		$client->setDeveloperKey("AIzaSyAzrhQr6XJq0HFcxL3q5Nb1cA85zEb8Khw");
		$client->setClientId($client_id);
		$client->setClientSecret($client_secret);
		$client->setScopes(array(
				'https://www.googleapis.com/auth/youtube',
				'https://www.googleapis.com/auth/youtubepartner',
				'https://www.googleapis.com/auth/youtube.upload',
		));
		$client->setAccessType('offline');
		
		if (!$client->getAccessToken()) {
			$service = new Google_Service_YouTube ( $client );
		
			$snippet = new Google_Service_YouTube_VideoSnippet ();
			$snippet->setTitle ( "Test title" );
			$snippet->setDescription ( "Test descrition" );
			$snippet->setTags ( array (
					"tag1",
					"tag2" 
			) );
			$snippet->setCategoryId ( "22" );
			
			$status = new Google_Service_YouTube_VideoStatus ();
			$status->privacyStatus = "private";
			
			$video = new Google_Service_YouTube_Video ();
			$video->setSnippet ( $snippet );
			$video->setStatus ( $status );
			
			$error = true;
			$i = 0;
			
			try {
				$obj = $service->videos->insert ( "status,snippet", $video, array (
						"data" => file_get_contents ( "/home/clomagno/Downloads/small.mp4" ),
						"mimeType" => "video/mp4" 
				) );
			} catch ( Google_ServiceException $e ) {
				print "Caught Google service Exception " . $e->getCode () . " message is " . $e->getMessage () . " <br>";
				print "Stack trace is " . $e->getTraceAsString ();
			}
		} else {
			throw new \Exception("ASD");
		}
	}
	
	public function createFromUploadedVideo(Application $app, $videoJSON, $news) {
		$video = new Video();
		$video->setEpigraph($videoJSON['epigraph']);
		$video->setUrl($videoJSON['url']);
		$video->setNews($news);
		
		$app['orm.em']->persist ( $video );
		$app['orm.em']->flush ();
		
		return $video;
	}
} 
