<?php

namespace tvtandil\common\socialmedia;

use Facebook\FacebookRequest;
use Facebook\GraphObject;
use Facebook\FacebookRequestException;
use Facebook\FacebookSession;
use tvtandil\model\entities\SocialMediaReference;
use tvtandil\model\entities\News;
use tvtandil\model\entities\tvtandil\model\entities;

class FacebookAdapter implements ISocialMediaAdapter {
	private $APP_ID = "1624052721149315";
	private $APP_SECRET = "3a4cb23a8c73141c92881df3d5b7ea6f";
	private $APP_TOKEN;
	private $APP_SECRET_PROOF;
	
	private $APP_PAGE_ACCESS_TOKEN = "CAAXFET2KZAYMBAEvZA1QOzTQjm1PIZBIvVmWhSbZC4OiV3c4ck0a3HRGuzrKBSCwBEn8jxhCtxGw4lBqrFyttBtD4ZAZA8ZCPYOAZAi5zB34H9W7DkPoNbZC1AIW5bAcqfVk3FQloyakd3AYIftBErSCKrpKPreGQhrerfpRTX7QEsZBZCIqG2CvlZAoSZAkczmCjpUQZD";

	private $facebookSession;
	
	private $app;
	
	public function __construct($app) {
		$this->app = $app;
		
		$this->APP_TOKEN = $this->APP_ID . "|" . $this->APP_SECRET;
		$this->APP_SECRET_PROOF = hash_hmac('sha256', $this->APP_PAGE_ACCESS_TOKEN, $this->APP_SECRET);
		
		FacebookSession::setDefaultApplication ( $this->APP_ID, $this->APP_SECRET );
		FacebookSession::enableAppSecretProof(true);
		$this->facebookSession = FacebookSession::newAppSession ( $this->APP_ID, $this->APP_SECRET );
	}
	
	public function post(News $news) {
		try {
			$params = array(
					"access_token" => $this->APP_PAGE_ACCESS_TOKEN, 
					"appsecret_proof" => $this->APP_SECRET_PROOF,
					"message" => "Here is a blog post about auto posting on Facebook using PHP #php #facebook",
					"link" => "http://www.pontikis.net/blog/auto_post_on_facebook_with_php",
					"picture" => "http://i.imgur.com/lHkOsiH.png",
					"name" => "How to Auto Post on Facebook with PHP",
					"caption" => "www.pontikis.net",
					"description" => "Automatically post on Facebook with PHP using Facebook PHP SDK. How to create a Facebook app. Obtain and extend Facebook access tokens. Cron automation."
			);
			
			$response = (new FacebookRequest($this->facebookSession, 'POST', '/825345654180922/feed', $params))->execute();
			
			if(!$news->getSocialMediaReference()){
				$socialMediaReference = new SocialMediaReference();
				$this->app ['orm.em']->persist ( $socialMediaReference );
				
				$news->setSocialMediaReference($socialMediaReference);
			}
			
			$news->getSocialMediaReference()->setFacebookPostId($response->getResponse()->id);
			
			$this->app ['orm.em']->persist ( $socialMediaReference );
			$this->app ['orm.em']->persist ( $news );
			$this->app ['orm.em']->flush ();
		} catch ( FacebookRequestException $e ) {
			echo "Exception occured, code: " . $e->getCode ();
			echo " with message: " . $e->getMessage ();
		}
		catch (\Exception $ex) {
			echo $ex->getMessage();
		}
	}
	
	public function delete(News $news){
		try {
			$socialMediaReference = $news->getSocialMediaReference();
			if($socialMediaReference){
				if($socialMediaReference->getFacebookPostId()){
					$params = array(
							"access_token" => $this->APP_PAGE_ACCESS_TOKEN,
							"appsecret_proof" => $this->APP_SECRET_PROOF
					);
					
					(new FacebookRequest($this->facebookSession, 'DELETE', '/' . $socialMediaReference->getFacebookPostId(), $params))->execute();
					
					$socialMediaReference->setFacebookPostId(null);
					$this->app ['orm.em']->persist ( $socialMediaReference );
					$this->app ['orm.em']->flush ();
				}
			}
		} catch ( FacebookRequestException $e ) {
			echo "Exception occured, code: " . $e->getCode ();
			echo " with message: " . $e->getMessage ();
		}
		catch (\Exception $ex) {
			echo $ex->getMessage();
		}
	}
}