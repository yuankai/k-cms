<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Entity\CategoryRepository")
 */
class Category {

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
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @var Myexp\Bundle\CmsBundle\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="pid", referencedColumnName="id", onDelete="SET NULL")
     */
    private $parent;

    /**
     *
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\OneToMany(targetEntity="CategoryTranslation", mappedBy="category", indexBy="lang", cascade={"persist", "remove"})
     */
    private $translations;

    /**
     * @ORM\OneToMany(targetEntity="Article", mappedBy="category", cascade={"remove"})
     */
    private $articles;

    /**
     * @ORM\OneToMany(targetEntity="Download", mappedBy="category", cascade={"remove"})
     */
    private $downloads;

    /**
     * @ORM\OneToMany(targetEntity="Page", mappedBy="category", cascade={"remove"})
     */
    private $pages;

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
     * @return Category
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
     * Set type
     *
     * @param int $type
     * @return Category
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType() {
        return $this->type;
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
     * Constructor
     */
    public function __construct() {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add categoryTranslation
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\CategoryTranslation $categoryTranslation
     * @return category
     */
    public function addTranslation(\Myexp\Bundle\CmsBundle\Entity\CategoryTranslation $categoryTranslation) {
        $categoryTranslation->setCategory($this);
        $this->translations[$categoryTranslation->getLang()] = $categoryTranslation;

        return $this;
    }

    /**
     * Remove categoryTranslation
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\CategoryTranslation $categoryTranslation
     */
    public function removeTranslation(\Myexp\Bundle\CmsBundle\Entity\CategoryTranslation $categoryTranslation) {
        $this->translations->removeElement($categoryTranslation);
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
     * Add article
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Article $article
     * @return Category
     */
    public function addArticle(\Myexp\Bundle\CmsBundle\Entity\Article $article) {
        $this->articles[] = $article;

        return $this;
    }

    /**
     * Remove article
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Article $article
     */
    public function removeArticle(\Myexp\Bundle\CmsBundle\Entity\Article $article) {
        $this->articles->removeElement($article);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArticles() {
        return $this->articles;
    }

    /**
     * Add download
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Download $download
     * @return Category
     */
    public function addDownload(\Myexp\Bundle\CmsBundle\Entity\Download $download) {
        $this->downloads[] = $download;

        return $this;
    }

    /**
     * Remove download
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Download $download
     */
    public function removeDownload(\Myexp\Bundle\CmsBundle\Entity\Download $download) {
        $this->downloads->removeElement($download);
    }

    /**
     * Get downloads
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDownloads() {
        return $this->downloads;
    }

    /**
     * Add page
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Page $page
     * @return Category
     */
    public function addPage(\Myexp\Bundle\CmsBundle\Entity\Page $page) {
        $this->pages[] = $page;

        return $this;
    }

    /**
     * Remove page
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Page $page
     */
    public function removePage(\Myexp\Bundle\CmsBundle\Entity\Page $page) {
        $this->pages->removeElement($page);
    }

    /**
     * Get pages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPages() {
        return $this->pages;
    }

    /**
     * Get top category
     *
     * @return \Myexp\Bundle\CmsBundle\Entity\Category 
     */
    public function getTopCategory() {

        $parentCategory = $this->getParent();

        if ($parentCategory) {
            return $parentCategory->getTopCategory();
        }

        return $this;
    }
    
    /**
     * Get all children
     * 
     * @return array all children
     */
    public function getAllChildren(){
        $children = array($this);
        
        $currChildren = $this->getChildren();
        if($currChildren){
            foreach($currChildren as $child){
                $children = array_merge($children, $child->getAllChildren());
            }
        }
        
        return $children;
    }

}
