<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Myexp\Bundle\AdminBundle\Entity\ContentEntity;

/**
 * Download
 *
 * @ORM\Table(name="downloads")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Repository\DownloadRepository")
 */
class Download extends ContentEntity {

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
     * @ORM\Column(name="publish_time", type="datetime", nullable=false)
     */
    private $publishTime;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_direct_download", type="boolean", nullable=true)
     */
    private $isDirectDownload;

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
     * @return Download
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
     * Set publishTime
     *
     * @param string $publishTime
     * @return Download
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
     * Set url
     *
     * @param string $url
     * @return Download
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
     * Set isDirectDownload
     *
     * @param boolean $isDirectDownload
     *
     * @return Node
     */
    public function setIsDirectDownload($isDirectDownload) {
        $this->isDirectDownload = $isDirectDownload;

        return $this;
    }

    /**
     * Get isDirectDownload
     *
     * @return boolean
     */
    public function getIsDirectDownload() {
        return $this->isDirectDownload;
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
