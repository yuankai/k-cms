<?php

namespace Myexp\Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="sliders")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\AdminBundle\Repository\SliderRepository")
 */
class Slider {

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
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(name="width", type="integer", nullable=false)
     * @Assert\NotBlank()
     */
    private $width;

    /**
     * @ORM\Column(name="height", type="integer", nullable=false)
     * @Assert\NotBlank()
     */
    private $height;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     */
    private $isActive;

    /**
     * @ORM\OneToMany(targetEntity="SliderPhoto", mappedBy="slider", cascade={"persist", "remove"})
     */
    private $sliderPhotos;

    /**
     * Constructor
     */
    public function __construct() {
        $this->sliderPhotos = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return Slider
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
     * @return Slider
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
     * Set width
     *
     * @param int $width
     * @return Slider
     */
    public function setWidth($width) {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return int 
     */
    public function getWidth() {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param int $height
     * @return Slider
     */
    public function setHeight($height) {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return int 
     */
    public function getHeight() {
        return $this->height;
    }
    
    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Slider
     */
    public function setIsActive($isActive) {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive() {
        return $this->isActive;
    }

    /**
     * Add sliderPhotos
     *
     * @param \Myexp\Bundle\AdminBundle\Entity\SliderPhoto $sliderPhoto
     * @return Slider
     */
    public function addSliderPhoto(\Myexp\Bundle\AdminBundle\Entity\SliderPhoto $sliderPhoto) {
        $sliderPhoto->setSlider($this);
        $this->sliderPhotos[] = $sliderPhoto;

        return $this;
    }

    /**
     * Remove sliderPhoto
     *
     * @param \Myexp\Bundle\AdminBundle\Entity\SliderPhoto $sliderPhoto
     */
    public function removeSliderPhoto(\Myexp\Bundle\AdminBundle\Entity\SliderPhoto $sliderPhoto) {
        $this->sliderPhotos->removeElement($sliderPhoto);
    }

    /**
     * Get sliderPhotos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSliderPhotos() {
        return $this->sliderPhotos;
    }

}