<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="slider_photos")
 * @ORM\Entity()
 */
class SliderPhoto {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(name="path", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $path;

    /**
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @ORM\Column(name="lang", type="string", length=255, nullable=true)
     */
    private $lang;

    /**
     * @ORM\Column(name="sort_order", type="integer", nullable=true)
     */
    private $sortOrder;

    /**
     * @ORM\ManyToOne(targetEntity="Slider", inversedBy="sliderPhotos", cascade={"persist"})
     * @ORM\JoinColumn(name="slider_id", referencedColumnName="id")
     */
    private $slider;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return SliderPhoto
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
     * Set path
     *
     * @param string $path
     * @return SliderPhoto
     */
    public function setPath($path) {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * Set link
     *
     * @param string $link
     * @return SliderPhoto
     */
    public function setLink($link) {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink() {
        return $this->link;
    }

    /**
     * Set lang
     *
     * @param String $lang
     * @return SliderPhoto
     */
    public function setLang($lang) {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get lang
     *
     * @return String 
     */
    public function getLang() {
        return $this->lang;
    }

    /**
     * Set sortOrder
     *
     * @param Integer $sortOrder
     * @return SliderPhoto
     */
    public function setSortOrder($sortOrder) {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    /**
     * Get sortOrder
     *
     * @return Integer 
     */
    public function getSortOrder() {
        return $this->sortOrder;
    }

    /**
     * Set slider
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Slider $slider
     * @return SliderPhoto
     */
    public function setSlider(\Myexp\Bundle\CmsBundle\Entity\Slider $slider = null) {
        $this->slider = $slider;

        return $this;
    }

    /**
     * Get slider
     *
     * @return \Myexp\Bundle\CmsBundle\Entity\Slider 
     */
    public function getSlider() {
        return $this->slider;
    }

}