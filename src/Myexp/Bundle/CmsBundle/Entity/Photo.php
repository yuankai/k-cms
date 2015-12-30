<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Myexp\Bundle\CmsBundle\Helper\Upload;

/**
 * @ORM\Table(name="photos")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Repository\PhotoRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Photo {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Album", inversedBy="photos")
     * @ORM\JoinColumn(name="album_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $album;

    /**
     * @var string
     *
     * @ORM\Column(name="picurl", type="string", length=255, nullable=true)
     */
    private $picurl;

    /**
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

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
     * @ORM\ManyToOne(targetEntity="Album", inversedBy="photos")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $user;

    /**
     * @Assert\Image(
     *     minWidth = 10,
     *     maxWidth = 2400,
     *     minHeight = 10,
     *     maxHeight = 2400
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

    /**
     * Set author
     *
     * @param string $author
     * @return Photo
     */
    public function setAuthor($author) {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * Set publishTime
     *
     * @param string $publishTime
     * @return Photo
     */
    public function setPublishTime($publishTime) {
        $this->publishTime = $publishTime;

        return $this;
    }

    /**
     * Get publishTime
     *
     * @return \DateTime  
     */
    public function getPublishTime() {
        return $this->publishTime;
    }

    /**
     * Set createTime
     *
     * @param string $createTime
     * @return Photo
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
     * @return Photo
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
     * Set album
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Album $album
     * @return Photo
     */
    public function setAlbum(\Myexp\Bundle\CmsBundle\Entity\Album $album = null) {
        $this->album = $album;

        return $this;
    }

    /**
     * Get album
     *
     * @return \Myexp\Bundle\CmsBundle\Entity\Album
     */
    public function getAlbum() {
        return $this->album;
    }

    /**
     * Set user
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\User $user
     * @return Photo
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return Photo
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
