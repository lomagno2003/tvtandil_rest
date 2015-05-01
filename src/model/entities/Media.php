<?php

namespace tvtandil\model\entities;
use JsonSerializable;

/**
 * @Entity @Table(name="media")
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="type", type="string")
 * @DiscriminatorMap({"media" = "Media", "image" = "Image", "video" = "Video"})
 */
class Media implements JsonSerializable {
	/**
	 * @Id @Column(type="integer") @GeneratedValue
	 */
	protected $id;
	
	/**
	 * @Column(type="string")
	 */
	protected $epigraph;

	/**
	 * @ManyToOne(targetEntity="News", inversedBy="media")
	 * @JoinColumn(name="news_id", referencedColumnName="id")
	 **/
	protected $news;
	public function getId() {
		return $this->id;
	}
	public function setEpigraph($epigraph) {
		$this->epigraph = $epigraph;
	}
	public function getEpigraph() {
		return $this->epigraph;
	}
	public function setNews($news){
		$this->news = $news;
	}
	
	public function jsonSerialize()
	{
		$result = array(
				'id' => $this->getId(),
				'epigraph' => $this->getEpigraph()
		);
			
		return $result;
	}
}