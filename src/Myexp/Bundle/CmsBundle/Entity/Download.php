<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Myexp\Bundle\CmsBundle\Helper\Upload;

/**
 * Download
 *
 * @ORM\Table(name="downloads")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Entity\DownloadRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Download {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="articles")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", nullable=true)
     */
    private $isActive;

    /**
     * @ORM\Column(name="publish_time", type="datetime", nullable=false)
     * @Assert\NotBlank()
     */
    private $publishTime;
    
    /**
     * @Assert\File()
     */
    private $file;

    /**
     * @var string
     */
    private $temp;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set category
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Category $category
     * @return Download
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
     * Set title
     *
     * @param string $title
     * @return Download
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
     * Set publishTime
     *
     * @param string $publishTime
     * @return Download
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
     * Set url
     *
     * @param string $url
     * @return Download
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return Download
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
    public function setFile(UploadedFile $file = null) {

        $this->file = $file;

        if (isset($this->url)) {
            $this->temp = $this->url;
        }
        $this->url = null;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {

        if (null !== $this->getFile()) {

            $filename = Upload:: genFileName();
            $this->url = $filename . '.' . $this->getFile()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload() {
        if (null !== $this->getFile()) {
            $this->getFile()->move
                    (Upload::getDownloadPath($this->url), $this->url);
            
            if (isset($this->temp)) {
                @unlink(Upload::getDownloadPath($this->temp) . $this->temp);
                $this->temp = null;
            }

            $this->file = null;
        }
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload() {

        $file = Upload::getDownloadPath($this->url) . $this->url;
        if (file_exists($file)) {
            @unlink($file);
        }
    }

}
