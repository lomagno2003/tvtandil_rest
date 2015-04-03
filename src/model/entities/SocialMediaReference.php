<?php

namespace tvtandil\model\entities;

/**
 * @Entity @Table(name="social_media_reference")
 */
class SocialMediaReference{
	/**
	 * @Id @Column(type="string")
	 */
	protected $id;
	
	/**
	 * @ManyToOne(targetEntity="News", inversedBy="socialMediaReference")
	 * @JoinColumn(name="news_id", referencedColumnName="id")
	 **/
	protected $news;
	
	public function getId() {
		return $this->id;
	}
	public function getNews() {
		return $this->news;
	}
}