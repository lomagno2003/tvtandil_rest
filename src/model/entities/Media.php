<?php

namespace tvtandil\model\entities;

/**
 * @Entity @Table(name="media")
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"media" = "Media", "image" = "Image"})
 */
class Media {
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
}