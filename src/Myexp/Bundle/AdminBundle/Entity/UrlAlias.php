<?php

namespace Myexp\Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UrlAlias
 *
 * @ORM\Table(name="url_aliases")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\AdminBundle\Repository\UrlAliasRepository")
 */
class UrlAlias {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, unique=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return UrlAlias
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
     * Set path
     *
     * @param string $path
     *
     * @return UrlAlias
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

}
