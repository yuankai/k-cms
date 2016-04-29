<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Myexp\Bundle\AdminBundle\Entity\ContentEntity;

/**
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Repository\ProductRepository")
 */
class Product extends ContentEntity {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Myexp\Bundle\AdminBundle\Entity\Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $category;

    /**
     * @ORM\OneToOne(targetEntity="Myexp\Bundle\AdminBundle\Entity\Content", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="content_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $content;

    /**
     * @ORM\OneToMany(targetEntity="ProductPhoto", mappedBy="product", cascade={"persist", "remove"})
     */
    private $productPhotos;

    /**
     * @var int
     * 
     * @ORM\Column(name="featuredOrder", type="integer", nullable=true)
     */
    private $featuredOrder;

    /**
     * @var int
     * 
     * @ORM\Column(name="stickOrder", type="integer", nullable=true)
     */
    private $stickOrder;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set category
     *
     * @param \Myexp\Bundle\AdminBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(\Myexp\Bundle\AdminBundle\Entity\Category $category = null) {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Myexp\Bundle\AdminBundle\Entity\Category
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * Set content
     *
     * @param \Myexp\Bundle\AdminBundle\Entity\Content $content
     *
     * @return Article
     */
    public function setContent(\Myexp\Bundle\AdminBundle\Entity\Content $content = null) {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return \Myexp\Bundle\AdminBundle\Entity\Content
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Add productPhoto
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\ProductPhoto $productPhoto
     * @return Slider
     */
    public function addProductPhoto(\Myexp\Bundle\CmsBundle\Entity\ProductPhoto $productPhoto) {
        $productPhoto->setProduct($this);
        $this->productPhotos[] = $productPhoto;

        return $this;
    }

    /**
     * Remove productPhoto
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\ProductPhoto $productPhoto
     */
    public function removeProductPhoto(\Myexp\Bundle\CmsBundle\Entity\ProductPhoto $productPhoto) {
        $this->productPhotos->removeElement($productPhoto);
    }

    /**
     * Get productPhotos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductPhotos() {
        return $this->productPhotos;
    }

    /**
     * 
     * @param type $featuredOrder
     */
    public function setFeaturedOrder($featuredOrder) {
        $this->featuredOrder = $featuredOrder;

        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getFeaturedOrder() {
        return $this->featuredOrder;
    }

    /**
     * 
     * @param type $stickOrder
     */
    public function setStickOrder($stickOrder) {
        $this->stickOrder = $stickOrder;

        return $this;
    }

    /**
     * 
     * @return type
     */
    public function getStickOrder() {
        return $this->stickOrder;
    }

}
