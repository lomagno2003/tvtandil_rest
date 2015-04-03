<?php

namespace tvtandil\common\socialmedia;

use tvtandil\model\entities\SocialMediaReference;
use \Codebird\Codebird;

class TwitterAdapter implements ISocialMediaAdapter {
	private $consumerKey = "s1hcYG3SISfqgXq3wMakDfzVu";
	private $consumerSecret = "ucJRtVz6ilhBM3l9vwahekUiMBhcqUqfTbcYQMad4ARTZ8zP5B";
	private $accessKey = "915662864-dXru6XzSPqKdr2xMSvkIiEUQTJALTy6JDxTQuJDe";
	private $accessSecret = "zA4W7vhaLgCmbACNnyTLJMBdN0AE3rZIAJZf1BdwKgQdS";
	
	private $codeBird;
	
	public function __construct(){
		Codebird::setConsumerKey($this->consumerKey, $this->consumerSecret);
		$this->codeBird = Codebird::getInstance();
		$this->codeBird->setToken($this->accessKey, $this->accessSecret);
	}
	
	public function post(SocialMediaReference $socialMediaReference) {
		$reply = $this->codeBird->statuses_update('status=Whohoo, I just tweeted!');
		echo json_decode($reply);
	}
}