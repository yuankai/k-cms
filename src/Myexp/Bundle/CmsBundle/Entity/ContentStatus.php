<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContentStatus
 *
 * @ORM\Table(name="content_status")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Repository\ContentStatusRepository")
 */
class ContentStatus {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="ContentModel")
     * @ORM\JoinColumn(name="content_model_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $contentModel;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ContentStatus
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
     *
     * @return ContentStatus
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
     * Set contentModel
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\ContentModel $contentModel
     *
     * @return ContentStatus
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

}
