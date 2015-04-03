<?php

namespace tvtandil\model\entities;

/**
 * @Entity @Table(name="image")
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
}