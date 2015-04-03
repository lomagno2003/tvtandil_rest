<?php

namespace tvtandil\model\entities;

use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;

/**
 * @Entity @Table(name="news")
 */
class News implements JsonSerializable{
	/**
	 * @Id @Column(type="integer") @GeneratedValue
	 */
	protected $id;
	
	/**
	 * @Column(type="string")
	 */
	protected $title;
	
	/**
	 * @Column(type="string")
	 */
	protected $description;
	
	/**
	 * @OneToMany(targetEntity="Media", mappedBy="news")
	 */
	protected $media;
	
	/**
	 * @OneToMany(targetEntity="SocialMediaReference", mappedBy="news")
	 */
	protected $socialMediaReference;
	
	/**
	 * @ManyToMany(targetEntity="Label", inversedBy="news")
	 * @JoinTable(name="news_label")
	 */
	protected $labels;
	public function __construct() {
		$this->media = new ArrayCollection ();
		$this->labels = new ArrayCollection ();
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
	public function setDescription($description) {
		$this->description = $description;
	}
	public function getDescription() {
		return $this->description;
	}
	public function getMedia() {
		return $this->media;
	}
	public function getLabels() {
		return $this->labels;
	}
	
	public function jsonSerialize()
	{
		$media = $this->media->toArray();
		
		$labels = $this->labels->toArray();
		
		$result = array(
				'id' => $this->id,
				'title'=> $this->title,
				'description'=> $this->description,
				'media' => $media,
				'labels' => $labels
		);
		 
		return $result; 
	}
}