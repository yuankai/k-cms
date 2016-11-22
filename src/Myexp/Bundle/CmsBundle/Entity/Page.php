<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Myexp\Bundle\AdminBundle\Entity\ContentEntity;

/**
 * @ORM\Table(name="pages")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Repository\PageRepository")
 */
class Page extends ContentEntity {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Myexp\Bundle\AdminBundle\Entity\Content", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="content_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $content;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param \Myexp\Bundle\AdminBundle\Entity\Content $content
     *
     * @return Page
     */
    public function setContent(\Myexp\Bundle\AdminBundle\Entity\Content $content = null) {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return \Myexp\Bundle\AdminBundle\Entity\Content
     */
    public function getContent() {
        return $this->content;
    }

}
