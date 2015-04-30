<?php

namespace tvtandil\common\socialmedia;

use tvtandil\model\entities\News;

interface ISocialMediaAdapter{
	public function post(News $news);
	
	public function delete(News $news);
}