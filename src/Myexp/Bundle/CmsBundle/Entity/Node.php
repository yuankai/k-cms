<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Node
 *
 * @ORM\Table(name="nodes")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Repository\NodeRepository")
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
     * @var integer
     *
     * @ORM\Column(name="websiteId", type="integer")
     */
    private $websiteId;

    /**
     * @var integer
     *
     * @ORM\Column(name="sequenceId", type="integer")
     */
    private $sequenceId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set websiteId
     *
     * @param integer $websiteId
     *
     * @return Node
     */
    public function setWebsiteId($websiteId) {
        $this->websiteId = $websiteId;

        return $this;
    }

    /**
     * Get websiteId
     *
     * @return integer
     */
    public function getWebsiteId() {
        return $this->websiteId;
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

}
