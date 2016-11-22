<?php

namespace Myexp\Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="menu_items")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\AdminBundle\Repository\MenuItemRepository")
 */
class MenuItem {

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
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(name="target", type="string", length=255, nullable=true)
     */
    private $target;

    /**
     * @ORM\Column(name="style", type="string", length=255, nullable=true)
     */
    private $style;

    /**
     * @var int
     * 
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
     * @var Myexp\Bundle\AdminBundle\Entity\Menu
     *
     * @ORM\ManyToOne(targetEntity="Menu")
     * @ORM\JoinColumn(name="menu_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $menu;

    /**
     * @var Myexp\Bundle\AdminBundle\Entity\MenuItem
     *
     * @ORM\ManyToOne(targetEntity="MenuItem", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $parent;

    /**
     *
     * @ORM\OneToMany(targetEntity="MenuItem", mappedBy="parent")
     */
    private $children;

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
     *
     * @return MenuItem
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
     * @return MenuItem
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
     * Set target
     *
     * @param string $target
     *
     * @return MenuItem
     */
    public function setTarget($target) {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target
     *
     * @return string
     */
    public function getTarget() {
        return $this->target;
    }

    /**
     * Set style
     *
     * @param string $style
     *
     * @return MenuItem
     */
    public function setStyle($style) {
        $this->style = $style;

        return $this;
    }

    /**
     * Get style
     *
     * @return string
     */
    public function getStyle() {
        return $this->style;
    }

    /**
     * Set sequenceId
     *
     * @param integer $sequenceId
     *
     * @return MenuItem
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return MenuItem
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
     * Set menu
     *
     * @param \Myexp\Bundle\AdminBundle\Entity\Menu $menu
     *
     * @return MenuItem
     */
    public function setMenu(\Myexp\Bundle\AdminBundle\Entity\Menu $menu = null) {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \Myexp\Bundle\AdminBundle\Entity\Menu
     */
    public function getMenu() {
        return $this->menu;
    }

    /**
     * Set parent
     *
     * @param \Myexp\Bundle\AdminBundle\Entity\MenuItem $parent
     *
     * @return MenuItem
     */
    public function setParent(\Myexp\Bundle\AdminBundle\Entity\MenuItem $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Myexp\Bundle\AdminBundle\Entity\MenuItem
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Add child
     *
     * @param \Myexp\Bundle\AdminBundle\Entity\MenuItem $child
     *
     * @return MenuItem
     */
    public function addChild(\Myexp\Bundle\AdminBundle\Entity\MenuItem $child) {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \Myexp\Bundle\AdminBundle\Entity\MenuItem $child
     */
    public function removeChild(\Myexp\Bundle\AdminBundle\Entity\MenuItem $child) {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren() {
        return $this->children;
    }

}
