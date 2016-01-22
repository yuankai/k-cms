<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Repository\CategoryRepository")
 */
class Category {

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
     * @ORM\Column(name="keywords", type="string", length=255, nullable=true)
     */
    private $keywords;
    
    /**
     * @ORM\OneToOne(targetEntity="UrlAlias", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="url_alias_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $urlAlias;

    /**
     * @var int
     * 
     * @ORM\Column(name="sequence_id", type="integer", nullable=true)
     */
    private $sequenceId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @var Myexp\Bundle\CmsBundle\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $parent;

    /**
     *
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     */
    private $children;

    /**
     * @var Myexp\Bundle\CmsBundle\Entity\Website
     *
     * @ORM\ManyToOne(targetEntity="Website")
     * @ORM\JoinColumn(name="websiteId", referencedColumnName="id", onDelete="SET NULL")
     * @Assert\NotBlank()
     */
    private $website;

    /**
     * @var Myexp\Bundle\CmsBundle\Entity\ContentModel
     *
     * @ORM\ManyToOne(targetEntity="ContentModel")
     * @ORM\JoinColumn(name="contentModelId", referencedColumnName="id", onDelete="SET NULL")
     * @Assert\NotBlank()
     */
    private $contentModel;

    /**
     * Constructor
     */
    public function __construct() {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set keywords
     *
     * @param string $keywords
     * @return Category
     */
    public function setKeywords($keywords) {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string 
     */
    public function getKeywords() {
        return $this->keywords;
    }
    
    /**
     * Set urlAlias
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\UrlAlias $urlAlias
     *
     * @return Content
     */
    public function setUrlAlias(\Myexp\Bundle\CmsBundle\Entity\UrlAlias $urlAlias = null) {
        $this->urlAlias = $urlAlias;

        return $this;
    }

    /**
     * Get urlAlias
     *
     * @return \Myexp\Bundle\CmsBundle\Entity\UrlAlias
     */
    public function getUrlAlias() {
        return $this->urlAlias;
    }

    /**
     * Set sequenceId
     *
     * @param int $sequenceId
     * @return Category
     */
    public function setSequenceId($sequenceId) {
        $this->sequenceId = $sequenceId;

        return $this;
    }

    /**
     * Get sequenceId
     *
     * @return int 
     */
    public function getSequenceId() {
        return $this->sequenceId;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Category
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
     * Set parent
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Category $parent
     * @return Menu
     */
    public function setParent(\Myexp\Bundle\CmsBundle\Entity\Category $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Myexp\Bundle\CmsBundle\Entity\Category 
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Add categoryChild
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Category $category
     * @return category
     */
    public function addChild(\Myexp\Bundle\CmsBundle\Entity\Category $category) {
        $category->setParent($this);
        $this->children[] = $category;

        return $this;
    }

    /**
     * Remove categoryChild
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Category $category
     */
    public function removeChild(\Myexp\Bundle\CmsBundle\Entity\Category $category) {
        $this->children->removeElement($category);
    }

    /**
     * Get categoryChildren
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * Set website
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Website $website
     * @return Category
     */
    public function setWebsite(\Myexp\Bundle\CmsBundle\Entity\Website $website) {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return \Myexp\Bundle\CmsBundle\Entity\Website 
     */
    public function getWebsite() {
        return $this->website;
    }

    /**
     * Set contentModel
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\ContentModel $contentModel
     * @return Category
     */
    public function setContentModel(\Myexp\Bundle\CmsBundle\Entity\ContentModel $contentModel) {
        $this->contentModel = $contentModel;

        return $this;
    }

    /**
     * Get contentModel
     *
     * @return string 
     */
    public function getContentModel() {
        return $this->contentModel;
    }

}
