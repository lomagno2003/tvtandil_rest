<?php

namespace tvtandil\common\socialmedia;

use tvtandil\model\entities\SocialMediaReference;
use \Codebird\Codebird;
use tvtandil\model\entities\News;

class TwitterAdapter implements ISocialMediaAdapter {
	private $consumerKey = "s1hcYG3SISfqgXq3wMakDfzVu";
	private $consumerSecret = "ucJRtVz6ilhBM3l9vwahekUiMBhcqUqfTbcYQMad4ARTZ8zP5B";
	private $accessKey = "915662864-dXru6XzSPqKdr2xMSvkIiEUQTJALTy6JDxTQuJDe";
	private $accessSecret = "zA4W7vhaLgCmbACNnyTLJMBdN0AE3rZIAJZf1BdwKgQdS";
	
	private $codeBird;
	
	private $app;
	
	public function __construct($app){
		$this->app = $app;
		
		Codebird::setConsumerKey($this->consumerKey, $this->consumerSecret);
		$this->codeBird = Codebird::getInstance();
		$this->codeBird->setToken($this->accessKey, $this->accessSecret);
	}
	
	public function post(News $news) {
		$params = array(
				'status' => 'Woho, i just made a tweet!'
		);
		$reply = $this->codeBird->statuses_update($params);
		
		if(!$news->getSocialMediaReference()){
			$socialMediaReference = new SocialMediaReference();
			$this->app ['orm.em']->persist ( $socialMediaReference );
		
			$news->setSocialMediaReference($socialMediaReference);
		}

		$news->getSocialMediaReference()->setTwitterPostId($reply->id);
			
		$this->app ['orm.em']->persist ( $socialMediaReference );
		$this->app ['orm.em']->persist ( $news );
		$this->app ['orm.em']->flush ();
	}
	
	public function delete(News $news) {
		$socialMediaReference = $news->getSocialMediaReference();
		if($socialMediaReference){
			if($socialMediaReference->getTwitterPostId()){
				$reply = $this->codeBird->statuses_destroy_ID('id=' . $news->getSocialMediaReference()->getTwitterPostId());
				
				$socialMediaReference->setFacebookPostId(null);
				$this->app ['orm.em']->persist ( $socialMediaReference );
				$this->app ['orm.em']->flush ();
			}
		}
	}
}