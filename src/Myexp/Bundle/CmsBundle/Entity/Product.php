<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Product {

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
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $category;

    /**
     * @ORM\Column(name="create_time", type="datetime", nullable=false)
     * @Assert\NotBlank()
     */
    private $createTime;

    /**
     * @ORM\Column(name="update_time", type="datetime", nullable=true)
     */
    private $updateTime;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
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
     * Set createTime
     *
     * @param string $createTime
     * @return Product
     */
    public function setCreateTime($createTime) {
        $this->createTime = $createTime;

        return $this;
    }

    /**
     * Get createTime
     *
     * @return \DateTime  
     */
    public function getCreateTime() {
        return $this->createTime;
    }

    /**
     * Set updateTime
     *
     * @param string $updateTime
     * @return Product
     */
    public function setUpdateTime($updateTime) {
        $this->updateTime = $updateTime;

        return $this;
    }

    /**
     * Get updateTime
     *
     * @return \DateTime  
     */
    public function getUpdateTime() {
        return $this->updateTime;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->setCreateTime(new \DateTime());
        $this->setUpdateTime($this->getCreateTime());
    }

    /**
     * Set category
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Category $category
     * @return Product
     */
    public function setCategory(\Myexp\Bundle\CmsBundle\Entity\Category $category = null) {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Myexp\Bundle\CmsBundle\Entity\Category
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Product
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
     * Set content
     *
     * @param string $content
     * @return Page
     */
    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent() {
        return $this->content;
    }

}
