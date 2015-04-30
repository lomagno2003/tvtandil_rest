<?php

namespace tvtandil\model\entities;

use tvtandil\common\images\ImageFactory;
/**
 * @Entity @Table(name="image")
 * @HasLifecycleCallbacks()
 */
class Image extends Media {
	/**
	 * @Column(type="string", nullable=true) *
	 */
	protected $url;
	public function getUrl() {
		return $this->url;
	}
	public function setUrl($url) {
		$this->url = $url;
	}
	
	/**
	 * @PreRemove
	 */
	public function deleteImageFile(){
		$path = ImageFactory::getImagePath($this);
		unlink($path);
	}
	
	public function jsonSerialize()
	{
		$result = parent::jsonSerialize();
		$result['url'] = $this->url;

		return $result;
	}
}