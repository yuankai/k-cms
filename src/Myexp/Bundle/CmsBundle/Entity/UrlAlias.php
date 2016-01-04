<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UrlAlias
 *
 * @ORM\Table(name="url_aliases")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Repository\UrlAliasRepository")
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="controller", type="string", length=255)
     */
    private $controller;

    /**
     * @var parameters
     *
     * @ORM\Column(name="parameters", type="string", length=255)
     */
    private $parameters;

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
     * Set controller
     *
     * @param string $controller
     *
     * @return UrlAlias
     */
    public function setController($controller) {
        $this->controller = $controller;

        return $this;
    }

    /**
     * Get controller
     *
     * @return string
     */
    public function getController() {
        return $this->controller;
    }

    /**
     * Set parameters
     *
     * @param string $parameters
     *
     * @return UrlAlias
     */
    public function setParameters($parameters) {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Get parameters
     *
     * @return string
     */
    public function getParameters() {
        return $this->parameters;
    }

}
