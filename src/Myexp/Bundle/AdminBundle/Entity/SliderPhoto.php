<?php

namespace Myexp\Bundle\AdminBundle\Entity;

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
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $url;

    /**
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @ORM\Column(name="sequence_id", type="integer", nullable=true)
     */
    private $sequenceId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     */
    private $isActive;

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
     * Set description
     *
     * @param string $description
     * @return SliderPhoto
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return SliderPhoto
     */
    public function setUrl($url) {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl() {
        return $this->url;
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
     * Set sequenceId
     *
     * @param Integer $sequenceId
     * @return SliderPhoto
     */
    public function setSequenceId($sequenceId) {
        $this->sequenceId = $sequenceId;

        return $this;
    }

    /**
     * Get sequenceId
     *
     * @return Integer 
     */
    public function getSequenceId() {
        return $this->sequenceId;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return SliderPhoto
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
     * Set slider
     *
     * @param \Myexp\Bundle\AdminBundle\Entity\Slider $slider
     * @return SliderPhoto
     */
    public function setSlider(\Myexp\Bundle\AdminBundle\Entity\Slider $slider = null) {
        $this->slider = $slider;

        return $this;
    }

    /**
     * Get slider
     *
     * @return \Myexp\Bundle\AdminBundle\Entity\Slider 
     */
    public function getSlider() {
        return $this->slider;
    }

}
