<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="albums")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Repository\AlbumRepository")
 */
class Album {

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
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $category;

    /**
     * @ORM\Column(name="keywords", type="string", length=255, nullable=true)
     */
    private $keywords;

    /**
     * @ORM\OneToOne(targetEntity="UrlAlias")
     * @ORM\JoinColumn(name="url_alias_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $urlAlias;

    /**
     * @var int
     * 
     * @ORM\Column(name="sort_order", type="integer", nullable=true)
     */
    private $sortOrder;

    /**
     * @ORM\ManyToMany(targetEntity="Photo")
     * @ORM\JoinTable(name="albums_photos")
     */
    private $photos;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="Website")
     * @ORM\JoinColumn(name="website_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $website;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="create_user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="update_user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $updateBy;

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
     * Set sortOrder
     *
     * @param int $sortOrder
     * @return Album
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
     * Constructor
     */
    public function __construct() {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add album
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Photo $photo
     * @return Photo
     */
    public function addPhoto(\Myexp\Bundle\CmsBundle\Entity\Photo $photo) {
        $this->photos[] = $photo;

        return $this;
    }

    /**
     * Remove album
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Album $album
     */
    public function removePhoto(\Myexp\Bundle\CmsBundle\Entity\Photo $photo) {
        $this->photos->removeElement($photo);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhotos() {
        return $this->photos;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Album
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

    /**
     * Set keywords
     *
     * @param string $keywords
     *
     * @return Album
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
     * Set category
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Category $category
     *
     * @return Album
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
     * Set urlAlias
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\UrlAlias $urlAlias
     *
     * @return Album
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
     * Set website
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Website $website
     *
     * @return Album
     */
    public function setWebsite(\Myexp\Bundle\CmsBundle\Entity\Website $website = null) {
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
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Album
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
     * Set createTime
     *
     * @param \DateTime $createTime
     *
     * @return Album
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
     * @param \DateTime $updateTime
     *
     * @return Album
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
     * Set createdBy
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\User $createdBy
     *
     * @return Album
     */
    public function setCreatedBy(\Myexp\Bundle\CmsBundle\Entity\User $createdBy = null) {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \Myexp\Bundle\CmsBundle\Entity\User
     */
    public function getCreatedBy() {
        return $this->createdBy;
    }

    /**
     * Set updateBy
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\User $updateBy
     *
     * @return Album
     */
    public function setUpdateBy(\Myexp\Bundle\CmsBundle\Entity\User $updateBy = null) {
        $this->updateBy = $updateBy;

        return $this;
    }

    /**
     * Get updateBy
     *
     * @return \Myexp\Bundle\CmsBundle\Entity\User
     */
    public function getUpdateBy() {
        return $this->updateBy;
    }

}
