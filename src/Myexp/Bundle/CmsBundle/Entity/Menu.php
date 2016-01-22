<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="menus")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Repository\MenuRepository")
 */
class Menu {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var Myexp\Bundle\CmsBundle\Entity\Website
     *
     * @ORM\ManyToOne(targetEntity="Website")
     * @ORM\JoinColumn(name="websiteId", referencedColumnName="id", onDelete="SET NULL")
     * @Assert\NotBlank()
     */
    private $website;

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
     *
     * @return Menu
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
     * @return Menu
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
     * Set website
     *
     * @param \Myexp\Bundle\CmsBundle\Entity\Website $website
     *
     * @return Menu
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

}
