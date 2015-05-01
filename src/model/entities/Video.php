<?php

namespace tvtandil\model\entities;

/**
 * @Entity @Table(name="video")
 */
class Video extends Media {
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
	
	public function jsonSerialize()
	{
		$result = parent::jsonSerialize();
		$result['url'] = $this->url;
		$result['type'] = 'video';

		return $result;
	}
}