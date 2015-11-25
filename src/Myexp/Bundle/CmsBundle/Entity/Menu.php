<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="menus")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Entity\MenuRepository")
 */
class Menu {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="path", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $path;

    /**
     * @var int
     * 
     * @ORM\Column(name="sort_order", type="integer", nullable=true)
     */
    private $sortOrder;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_nav", type="boolean", nullable=true)
     */
    private $isNav;
    
        /**
     * @var boolean
     *
     * @ORM\Column(name="is_Index", type="boolean", nullable=true)
     */
    private $isIndex;

    /**
     * @var Myexp\Bundle\CmsBundle\Entity\Menu
     *
     * @ORM\ManyToOne(targetEntity="Menu")
     * @ORM\JoinColumn(name="pid", referencedColumnName="id", onDelete="SET NULL")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="MenuTranslation", mappedBy="menu", indexBy="lang", cascade={"persist", "remove"})
     */
    private $translations;

    /**
     * Constructor
     */
    public function __construct() {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set path
     *
     * @param string $path
     * @return Menu
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
     * Set sortOrder
     *
     * @param int $sortOrder
     * @return Menu
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
     * Set isNav
     *
     * @param boolean $isNav
     * @return Menu
     */
    public function setIsNav($isNav) {
        $this->isNav = $isNav;

        return $this;
    }

    /**
     * Get isNav
     *
     * @return boolean 
     */
    public function getIsNav() {
        return $this->isNav;
    }
    
        /**
     * Get isIndex
     *
     * @return boolean 
     */
    public function getIsIndex() {
        return $this->isIndex;
    }
    
      /**
     * Set isIndex
     *
     * @param boolean $isIndex
     * @return Menu
     */
    public function setIsIndex($isIndex) {
        $this->isIndex = $isIndex;

        return $this;
    }

    /**
     * Set parent
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Menu $parent
     * @return Menu
     */
    public function setParent(\Myexp\Bundle\CmsBundle\Entity\Menu $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Myexp\Bundle\CmsBundle\Entity\Menu 
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Add translations
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\MenuTranslation $menuTranslation
     * @return Menu
     */
    public function addTranslation(\Myexp\Bundle\CmsBundle\Entity\MenuTranslation $menuTranslation) {
        $menuTranslation->setMenu($this);
        $this->translations[$menuTranslation->getLang()] = $menuTranslation;

        return $this;
    }

    /**
     * Remove translation
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\MenuTranslation $menuTranslation
     */
    public function removeTranslation(\Myexp\Bundle\CmsBundle\Entity\MenuTranslation $menuTranslation) {
        $this->translations->removeElement($menuTranslation);
    }

    /**
     * Get translations
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
     * @return \Myexp\Bundle\CmsBundle\Entity\MenuTranslation $menuTranslation
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

}