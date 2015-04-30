<?php

namespace tvtandil\model\entities;

/**
 * @Entity @Table(name="social_media_reference")
 */
class SocialMediaReference{
	/**
	 * @Id @Column(type="integer") @GeneratedValue
	 */
	protected $id;
	
	/**
	 * @Column(type="string", nullable=true)
	 */
	protected $facebookPostId;
	
	/**
	 * @Column(type="string", nullable=true)
	 */
	protected $twitterPostId;
	
	public function getId() {
		return $this->id;
	}
	public function setFacebookPostId($facebookPostId){
		$this->facebookPostId = $facebookPostId;
	}
	public function getFacebookPostId(){
		return $this->facebookPostId;
	}
	public function setTwitterPostId($twitterPostId){
		$this->twitterPostId = $twitterPostId;
	}
	public function getTwitterPostId(){
		return $this->twitterPostId;
	}
}