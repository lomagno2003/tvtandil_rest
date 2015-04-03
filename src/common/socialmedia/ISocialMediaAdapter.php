<?php

namespace tvtandil\common\socialmedia;

use tvtandil\model\entities\SocialMediaReference;

interface ISocialMediaAdapter{
	public function post(SocialMediaReference $socialMediaReference);
}