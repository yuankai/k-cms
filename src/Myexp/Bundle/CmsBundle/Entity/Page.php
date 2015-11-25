<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Myexp\Bundle\CmsBundle\Helper\Upload;

/**
 * @ORM\Table(name="pages")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Entity\PageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Page {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="pages")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $category;

    /**
     * @var int
     * 
     * @ORM\Column(name="sort_order", type="integer", nullable=true)
     */
    private $sortOrder;

    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="picurl", type="string", length=255, nullable=true)
     */
    private $picurl;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="pages")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="PageTranslation", mappedBy="page", indexBy="lang", cascade={"persist", "remove"})
     */
    private $translations;

    /**
     * @Assert\Image(
     *     minWidth = 40,
     *     maxWidth = 4000,
     *     minHeight = 40,
     *     maxHeight = 4000
     * )
     */
    private $filePhoto;

    /**
     * @var string
     */
    private $tempPhoto;

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
     * Set picurl
     *
     * @param string $picurl
     * @return Photo
     */
    public function setPicUrl($picurl) {
        $this->picurl = $picurl;

        return $this;
    }

    /**
     * Get picurl
     *
     * @return string 
     */
    public function getPicUrl() {
        return $this->picurl;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add pageTranslation
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\PageTranslation $pageTranslation
     * @return Page
     */
    public function addTranslation(\Myexp\Bundle\CmsBundle\Entity\PageTranslation $pageTranslation) {
        $pageTranslation->setPage($this);
        $this->translations[$pageTranslation->getLang()] = $pageTranslation;

        return $this;
    }

    /**
     * Remove pageTranslation
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\PageTranslation $pageTranslation
     */
    public function removeTranslation(\Myexp\Bundle\CmsBundle\Entity\PageTranslation $pageTranslation) {
        $this->translations->removeElement($pageTranslation);
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
     * Set category
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Category $category
     * @return Article
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
     * Set user
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\User $user
     * @return Article
     */
    public function setUser(\Myexp\Bundle\CmsBundle\Entity\User $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Myexp\Bundle\CmsBundle\Entity\User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFilePhoto(UploadedFile $filePhoto = null) {

        $this->filePhoto = $filePhoto;

        if (isset($this->picurl)) {
            $this->tempPhoto = $this->picurl;
        }
        $this->picurl = null;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFilePhoto() {
        return $this->filePhoto;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {

        if (null !== $this->getFilePhoto()) {

            $filename = Upload:: genFileName();
            $this->picurl = $filename . '.' . $this->getFilePhoto()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload() {
        if (null !== $this->getFilePhoto()) {
            $this->getFilePhoto()->move
                    (Upload::getSavePath($this->picurl), $this->picurl);

            if (isset($this->tempPhoto)) {
                @unlink(Upload::getSavePath($this->tempPhoto) . $this->tempPhoto);
                $this->tempPhoto = null;
            }

            $this->filePhoto = null;
        }
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload() {

        $file = Upload::getSavePath($this->picurl) . $this->picurl;
        if (file_exists($file)) {
            @unlink($file);
        }
    }

}
