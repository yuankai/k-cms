<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Myexp\Bundle\CmsBundle\Helper\Upload;

/**
 * @ORM\Table(name="links")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Entity\LinkRepository")
 * * @ORM\HasLifecycleCallbacks
 */
class Link {

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
     * @var string
     *
     * @ORM\Column(name="picurl", type="string", length=255, nullable=true)
     */
    private $picurl;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @ORM\OneToMany(targetEntity="LinkTranslation", mappedBy="link", indexBy="lang", cascade={"persist", "remove"})
     */
    private $translations;

    /**
     * @Assert\Image(
     *     minWidth = 10,
     *     maxWidth = 800,
     *     minHeight = 10,
     *     maxHeight = 200
     * )
     */
    private $filePhoto;

    /**
     * @var string
     */
    private $tempPhoto;

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
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive() {
        return $this->isActive;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Article
     */
    public function setIsActive($isActive) {
        $this->isActive = $isActive;

        return $this;
    }

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
