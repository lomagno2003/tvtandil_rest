<?php

namespace tvtandil\model\entities;

use Doctrine\Common\Collections\ArrayCollection;
use JsonSerializable;

/**
 * @Entity @Table(name="label")
 */
class Label implements JsonSerializable{
	/**
	 * @Id @Column(type="string")
	 */
	protected $id;
	
	/**
	 * @Column(type="string")
	 */
	protected $description;
	
	/**
	 * @ManyToMany(targetEntity="News", mappedBy="labels")
	 */
	protected $news;
	public function __construct() {
		$this->news = new ArrayCollection ();
	}
	public function getId() {
		return $this->id;
	}
	public function setDescription($description) {
		$this->description = $description;
	}
	public function getDescription() {
		return $this->description;
	}
	public function getNews() {
		return $this->news;
	}
	
	public function jsonSerialize()
	{
		$result = array(
			'id' => $this->id,
			'description' => $this->description
		);
			
		return $result;
	}
}