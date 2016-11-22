<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Myexp\Bundle\AdminBundle\Entity\ContentEntity;

/**
 * @ORM\Table(name="articles")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Repository\ArticleRepository")
 */
class Article extends ContentEntity {

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
     * @ORM\Column(name="image_url", type="string", length=255, nullable=true)
     */
    private $imageUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255, nullable=true)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=255, nullable=true)
     */
    private $source;

    /**
     * @ORM\Column(name="publish_time", type="datetime", nullable=false)
     * @Assert\NotBlank()
     */
    private $publishTime;

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
     * Constructor
     */
    public function __construct() {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set category
     *
     * @param \Myexp\Bundle\AdminBundle\Entity\Category $category
     *
     * @return Article
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
     * Set author
     *
     * @param string $author
     *
     * @return Article
     */
    public function setAuthor($author) {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * Set source
     *
     * @param string $source
     *
     * @return Article
     */
    public function setSource($source) {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource() {
        return $this->source;
    }

    /**
     * Set publishTime
     *
     * @param \DateTime $publishTime
     *
     * @return Article
     */
    public function setPublishTime($publishTime) {
        $this->publishTime = $publishTime;

        return $this;
    }

    /**
     * Get publishTime
     *
     * @return \DateTime
     */
    public function getPublishTime() {
        return $this->publishTime;
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
     * Set imageUrl
     *
     * @param string $imageUrl
     *
     * @return Article
     */
    public function setImageUrl($imageUrl = null) {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get imageUrl
     *
     * @return string
     */
    public function getImageUrl() {
        return $this->imageUrl;
    }

}
