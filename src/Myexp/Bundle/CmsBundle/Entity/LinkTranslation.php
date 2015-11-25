<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="link_translations")
 * @ORM\Entity()
 */
class LinkTranslation {

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
     * @ORM\Column(name="lang", type="string", length=20, nullable=false)
     */
    private $lang;

    /**
     * @ORM\ManyToOne(targetEntity="Link", inversedBy="translations")
     * @ORM\JoinColumn(name="link_id", referencedColumnName="id")
     */
    private $link;

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
     * Set link
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Link $link
     * @return LinkTranslation
     */
    public function setLink(\Myexp\Bundle\CmsBundle\Entity\Link $link = null) {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return \Myexp\Bundle\CmsBundle\Entity\Link 
     */
    public function getLink() {
        return $this->link;
    }

}