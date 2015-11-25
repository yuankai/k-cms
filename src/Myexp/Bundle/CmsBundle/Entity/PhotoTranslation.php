<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="photo_translations")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Entity\PhotoTranslationRepository")
 */
class PhotoTranslation {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(name="lang", type="string", length=20, nullable=false)
     */
    private $lang;

    /**
     * @ORM\ManyToOne(targetEntity="Photo", inversedBy="translations")
     * @ORM\JoinColumn(name="photo_id", referencedColumnName="id")
     */
    private $photo;

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
     * Set lang
     *
     * @param string $lang
     * @return Page
     */
    public function setLang($lang) {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get lang
     *
     * @return string 
     */
    public function getLang() {
        return $this->lang;
    }

    /**
     * Set album
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Photo $album
     * @return PageTranslation
     */
    public function setPhoto(\Myexp\Bundle\CmsBundle\Entity\Photo $photo = null) {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get album
     *
     * @return \Myexp\Bundle\CmsBundle\Entity\Photo 
     */
    public function getPhoto() {
        return $this->photo;
    }

}