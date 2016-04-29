<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="product_photos")
 * @ORM\Entity()
 */
class ProductPhoto {

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
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $url;

    /**
     * @ORM\Column(name="sequence_id", type="integer", nullable=true)
     */
    private $sequenceId;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="productPhotos", cascade={"persist"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

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
     * @return ProductPhoto
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
     * @return ProductPhoto
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
     * @param Integer $sequenceId
     * @return ProductPhoto
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
     * Set product
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Product $product
     * @return ProductPhoto
     */
    public function setProduct(\Myexp\Bundle\CmsBundle\Entity\Product $product = null) {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Myexp\Bundle\CmsBundle\Entity\Product 
     */
    public function getProduct() {
        return $this->product;
    }

}
