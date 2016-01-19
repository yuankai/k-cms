<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="albums")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Repository\AlbumRepository")
 */
class Album {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="keywords", type="string", length=255, nullable=false)
     */
    private $keywords;

    /**
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;
    
    /**
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $category;

    /**
     * @var int
     * 
     * @ORM\Column(name="sort_order", type="integer", nullable=true)
     */
    private $sortOrder;

    /**
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="album", cascade={"remove"})
     */
    private $photos;
    
    /**
     * @ORM\ManyToOne(targetEntity="Website")
     * @ORM\JoinColumn(name="website_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $website;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Page
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Page
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set sortOrder
     *
     * @param int $sortOrder
     * @return Album
     */
    public function setSortOrder($sortOrder) {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    /**
     * Get sortOrder
     *
     * @return int 
     */
    public function getSortOrder() {
        return $this->sortOrder;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add album
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Photo $photo
     * @return Photo
     */
    public function addPhoto(\Myexp\Bundle\CmsBundle\Entity\Photo $photo) {
        $this->photos[] = $photo;

        return $this;
    }

    /**
     * Remove album
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Album $album
     */
    public function removePhoto(\Myexp\Bundle\CmsBundle\Entity\Photo $photo) {
        $this->photos->removeElement($photo);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhotos() {
        return $this->photos;
    }

}
