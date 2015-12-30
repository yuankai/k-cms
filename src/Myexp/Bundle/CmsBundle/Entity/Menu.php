<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="menus")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Repository\MenuRepository")
 */
class Menu {

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
     * Constructor
     */
    public function __construct() {
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

}
