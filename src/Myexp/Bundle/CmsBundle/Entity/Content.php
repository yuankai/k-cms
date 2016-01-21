<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="contents")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Repository\ContentRepository")
 */
class Content {

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
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

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
     * @ORM\OneToOne(targetEntity="UrlAlias", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="url_alias_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $urlAlias;

    /**
     * @ORM\ManyToOne(targetEntity="Website")
     * @ORM\JoinColumn(name="website_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $website;

    /**
     * @ORM\ManyToOne(targetEntity="ContentModel")
     * @ORM\JoinColumn(name="content_model_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $contentModel;

    /**
     * @ORM\ManyToOne(targetEntity="ContentStatus")
     * @ORM\JoinColumn(name="content_status_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $contentStatus;

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
     * Constructor
     */
    public function __construct() {
        $this->setCreateTime(new \DateTime());
        $this->setUpdateTime($this->getCreateTime());
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
     * @return Content
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
     * Set description
     *
     * @param string $description
     *
     * @return Content
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     *
     * @return Content
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
     * Set createTime
     *
     * @param \DateTime $createTime
     *
     * @return Content
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
     * @return Content
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
     * Set category
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Category $category
     *
     * @return Content
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
     * Set website
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Website $website
     *
     * @return Content
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
     * Set contentModel
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\ContentModel $contentModel
     *
     * @return Content
     */
    public function setContentModel(\Myexp\Bundle\CmsBundle\Entity\ContentModel $contentModel = null) {
        $this->contentModel = $contentModel;

        return $this;
    }

    /**
     * Get contentModel
     *
     * @return \Myexp\Bundle\CmsBundle\Entity\ContentModel
     */
    public function getContentModel() {
        return $this->contentModel;
    }

    /**
     * Set createdBy
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\User $createdBy
     *
     * @return Content
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
     * @return Content
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

    /**
     * Set contentStatus
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\ContentStatus $contentStatus
     *
     * @return Content
     */
    public function setContentStatus(\Myexp\Bundle\CmsBundle\Entity\ContentStatus $contentStatus = null) {
        $this->contentStatus = $contentStatus;

        return $this;
    }

    /**
     * Get contentStatus
     *
     * @return \Myexp\Bundle\CmsBundle\Entity\ContentStatus
     */
    public function getContentStatus() {
        return $this->contentStatus;
    }

}
