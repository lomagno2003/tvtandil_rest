<?php

namespace tvtandil\common\socialmedia;

use Facebook\FacebookRequest;
use Facebook\GraphObject;
use Facebook\FacebookRequestException;
use Facebook\FacebookSession;
use tvtandil\model\entities\SocialMediaReference;

class FacebookAdapter implements ISocialMediaAdapter {
	private $APP_ID = "1624052721149315";
	private $APP_SECRET = "3a4cb23a8c73141c92881df3d5b7ea6f";
	private $APP_CODE = "AQCrbEGqKbKA0WZ5ZVzOxgxXOagHtFOmrA6ezKM7wIZDVZxWmDLbT4VS8pBwYN1-iZumIwYCjcroePuncWNPaJyFbWh0d968iRtkXAmyu0x_Ccc0by0Rsl8RZ3VpQ5uRSb3lPye4eCPs2BseVhbMoaAhTgtSFUWDkdc5ICjHXSFO1sC-JcSBlH_XXaTRsJRF_2ouiBB4pdhErqrfFU2Is7nvPvdFArgsWJJz0-bFsFIQda7HcsfwZ0XytGt1zk6V2-aJH4qL1BIu-wRse0ryYNanSqzF5-E5M686xgR9uncoEkgvGh-xBohsSKWEznvd7pk#_=_";
	private $facebookSession;
	public function __construct() {
		FacebookSession::setDefaultApplication ( $this->APP_ID, $this->APP_SECRET );
		$this->facebookSession = FacebookSession::newAppSession ( $this->APP_ID, $this->APP_SECRET );
	}
	public function post(SocialMediaReference $socialMediaReference) {
		try {
			$accessToken = $this->facebookSession->getAccessToken ()->getAccessTokenFromCode ( $this->APP_CODE );
			$userId = $this->facebookSession->getUserId ();
			echo $accessToken;
		} catch ( FacebookRequestException $e ) {
			echo "Exception occured, code: " . $e->getCode ();
			echo " with message: " . $e->getMessage ();
		}
	}
}