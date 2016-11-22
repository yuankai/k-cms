<?php

namespace Myexp\Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="links")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\AdminBundle\Repository\LinkRepository")
 */
class Link {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     */
    private $url;

    /**
     * @var int
     * 
     * @ORM\Column(name="sequence_id", type="integer", nullable=true)
     */
    private $sequenceId;

    /**
     * @var string
     *
     * @ORM\Column(name="logo_url", type="string", length=255, nullable=true)
     */
    private $logoUrl;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @var Myexp\Bundle\AdminBundle\Entity\Website
     *
     * @ORM\ManyToOne(targetEntity="Website")
     * @ORM\JoinColumn(name="website_id", referencedColumnName="id", onDelete="SET NULL")
     * @Assert\NotBlank()
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
     * Set title
     *
     * @param string $title
     *
     * @return Link
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
     * Set url
     *
     * @param string $url
     *
     * @return Link
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
     * Set sequenceId
     *
     * @param integer $sequenceId
     *
     * @return Link
     */
    public function setSequenceId($sequenceId) {
        $this->sequenceId = $sequenceId;

        return $this;
    }

    /**
     * Get sequenceId
     *
     * @return integer
     */
    public function getSequenceId() {
        return $this->sequenceId;
    }

    /**
     * Set logoUrl
     *
     * @param string $logoUrl
     *
     * @return Link
     */
    public function setLogoUrl($logoUrl) {
        $this->logoUrl = $logoUrl;

        return $this;
    }

    /**
     * Get logoUrl
     *
     * @return string
     */
    public function getLogoUrl() {
        return $this->logoUrl;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Link
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
     * Set website
     *
     * @param \Myexp\Bundle\AdminBundle\Entity\Website $website
     * @return Category
     */
    public function setWebsite(\Myexp\Bundle\AdminBundle\Entity\Website $website) {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return \Myexp\Bundle\AdminBundle\Entity\Website 
     */
    public function getWebsite() {
        return $this->website;
    }

}
