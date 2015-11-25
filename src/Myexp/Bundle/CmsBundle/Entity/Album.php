<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="albums")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Entity\AlbumRepository")
 */
class Album {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var int
     * 
     * @ORM\Column(name="sort_order", type="integer", nullable=true)
     */
    private $sortOrder;
    
    
    /**
     * @ORM\OneToMany(targetEntity="AlbumTranslation", mappedBy="album", indexBy="lang", cascade={"persist", "remove"})
     */
    private $translations;

    /**
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="album", cascade={"remove"})
     */
    private $photos;

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
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add albumTranslation
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\AlbumTranslation $albumTranslation
     * @return album
     */
    public function addTranslation(\Myexp\Bundle\CmsBundle\Entity\AlbumTranslation $albumTranslation) {
        $albumTranslation->setAlbum($this);
        $this->translations[$albumTranslation->getLang()] = $albumTranslation;

        return $this;
    }

    /**
     * Remove albumTranslation
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\AlbumTranslation $albumTranslation
     */
    public function removeTranslation(\Myexp\Bundle\CmsBundle\Entity\AlbumTranslation $albumTranslation) {
        $this->translations->removeElement($albumTranslation);
    }

    /**
     * Get pageTranslations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTranslations() {
        return $this->translations;
    }

    /**
     * Get current locale translation
     * 
     * @param string $locale Locale
     * @return \Doctrine\Common\Collections\Collection $pageTranslation
     */
    public function getTrans($locale = NULL) {

        if ($locale === NULL) {
            global $kernel;
            $locale = $kernel->getContainer()->get('request')->getLocale();
        }

        if (!isset($this->translations[$locale])) {
            return false;
        }

        return $this->translations[$locale];
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