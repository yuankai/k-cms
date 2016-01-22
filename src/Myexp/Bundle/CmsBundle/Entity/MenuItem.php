<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="menu_items")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Repository\MenuItemRepository")
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
     * @var int
     * 
     * @ORM\Column(name="sequence_id", type="integer", nullable=true)
     */
    private $sequenceId;

    /**
     * @var Myexp\Bundle\CmsBundle\Entity\Menu
     *
     * @ORM\ManyToOne(targetEntity="Menu")
     * @ORM\JoinColumn(name="menu_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $menu;

    /**
     * @var Myexp\Bundle\CmsBundle\Entity\MenuItem
     *
     * @ORM\ManyToOne(targetEntity="MenuItem")
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
     * Set menu
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Menu $menu
     *
     * @return MenuItem
     */
    public function setMenu(\Myexp\Bundle\CmsBundle\Entity\Menu $menu = null) {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return \Myexp\Bundle\CmsBundle\Entity\Menu
     */
    public function getMenu() {
        return $this->menu;
    }

    /**
     * Set parent
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\MenuItem $parent
     *
     * @return MenuItem
     */
    public function setParent(\Myexp\Bundle\CmsBundle\Entity\MenuItem $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Myexp\Bundle\CmsBundle\Entity\MenuItem
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Add child
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\MenuItem $child
     *
     * @return MenuItem
     */
    public function addChild(\Myexp\Bundle\CmsBundle\Entity\MenuItem $child) {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\MenuItem $child
     */
    public function removeChild(\Myexp\Bundle\CmsBundle\Entity\MenuItem $child) {
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
