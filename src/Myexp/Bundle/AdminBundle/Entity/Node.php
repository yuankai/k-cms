<?php

namespace Myexp\Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Node
 *
 * @ORM\Table(name="nodes")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\AdminBundle\Repository\NodeRepository")
 */
class Node {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @var integer
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
     * @var Myexp\Bundle\AdminBundle\Entity\Website
     *
     * @ORM\ManyToOne(targetEntity="Website")
     * @ORM\JoinColumn(name="website_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $website;

    /**
     * @var Myexp\Bundle\AdminBundle\Entity\Node
     *
     * @ORM\ManyToOne(targetEntity="Node", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $parent;

    /**
     *
     * @ORM\OneToMany(targetEntity="Node", mappedBy="parent")
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
     * @return Node
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
     *
     * @return Node
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
     * Set sequenceId
     *
     * @param integer $sequenceId
     *
     * @return Node
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
     *
     * @return Node
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
     * Set website
     *
     * @param \Myexp\Bundle\AdminBundle\Entity\Website $website
     *
     * @return Node
     */
    public function setWebsite(\Myexp\Bundle\AdminBundle\Entity\Website $website = null) {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return \Myexp\Bundle\AdminBundle\Entity\Website
     */
    public function getWebsite() {
        return $this->website;
    }

    /**
     * Set parent
     *
     * @param \Myexp\Bundle\AdminBundle\Entity\Node $parent
     *
     * @return Node
     */
    public function setParent(\Myexp\Bundle\AdminBundle\Entity\Node $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Myexp\Bundle\AdminBundle\Entity\Node
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Add child
     *
     * @param \Myexp\Bundle\AdminBundle\Entity\Node $child
     *
     * @return Node
     */
    public function addChild(\Myexp\Bundle\AdminBundle\Entity\Node $child) {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \Myexp\Bundle\AdminBundle\Entity\Node $child
     */
    public function removeChild(\Myexp\Bundle\AdminBundle\Entity\Node $child) {
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

    /**
     * Get top node
     * 
     * @return Node
     */
    public function getTopNode(){
        
        $currParent = $this->getParent();
        if($currParent){
            return $currParent->getTopNode();
        }
        
        return $this;
    }
}
