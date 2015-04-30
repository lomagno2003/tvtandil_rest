<?php

namespace tvtandil\common\socialmedia;

use tvtandil\model\entities\News;

class CompositeSocialMediaAdapter implements ISocialMediaAdapter {
	private $socialMediaAdapters;
	
	public function __construct(){
		$this->socialMediaAdapters = func_get_args();
	}
	
	public function post(News $news) {
		foreach($this->socialMediaAdapters as $socialMediaAdapter){
			$socialMediaAdapter->post($news);
		}
	}
	public function delete(News $news) {
		foreach($this->socialMediaAdapters as $socialMediaAdapter){
			$socialMediaAdapter->delete($news);
		}
	}
}