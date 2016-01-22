<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="articles")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Repository\ArticleRepository")
 */
class Article {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Content", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="content_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $content;

    /**
     * @ORM\ManyToMany(targetEntity="Photo")
     * @ORM\JoinTable(name="articles_photos")
     */
    private $photos;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255, nullable=true)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=255, nullable=true)
     */
    private $source;

    /**
     * @ORM\Column(name="publish_time", type="datetime", nullable=false)
     * @Assert\NotBlank()
     */
    private $publishTime;

    /**
     * Constructor
     */
    public function __construct() {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set author
     *
     * @param string $author
     *
     * @return Article
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
     * Set source
     *
     * @param string $source
     *
     * @return Article
     */
    public function setSource($source) {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource() {
        return $this->source;
    }

    /**
     * Set publishTime
     *
     * @param \DateTime $publishTime
     *
     * @return Article
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
     * Set content
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Content $content
     *
     * @return Article
     */
    public function setContent(\Myexp\Bundle\CmsBundle\Entity\Content $content = null) {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return \Myexp\Bundle\CmsBundle\Entity\Content
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Add photo
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Photo $photo
     *
     * @return Article
     */
    public function addPhoto(\Myexp\Bundle\CmsBundle\Entity\Photo $photo) {
        $this->photos[] = $photo;

        return $this;
    }

    /**
     * Remove photo
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Photo $photo
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

}
