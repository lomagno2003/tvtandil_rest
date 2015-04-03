<?php

namespace tvtandil\model\entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table(name="news")
 */
class News {	
	/**
	 * @Id @Column(type="integer") @GeneratedValue
	 */
	protected $id;
	
	/**
	 * @Column(type="string")
	 */
	protected $title;
	

	/**
     * @OneToMany(targetEntity="Media", mappedBy="news")
     **/
	protected $media;
	
	public function __construct() {
		$this->media = new ArrayCollection ();
	}
	public function getId() {
		return $this->id;
	}
	public function setTitle($title) {
		$this->title = $title;
	}
	public function getTitle() {
		return $this->title;
	}
	public function getMedia(){
		return $this->media->toArray();
	}
}