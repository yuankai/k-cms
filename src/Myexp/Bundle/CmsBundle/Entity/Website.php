<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Website
 *
 * @ORM\Table(name="websites")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Repository\WebsiteRepository")
 */
class Website {

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="http_url", type="string", length=255, nullable=true)
     */
    private $httpUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="https_url", type="string", length=255, nullable=true)
     */
    private $httpsUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="icp_num", type="string", length=255, nullable=true)
     */
    private $icpNum;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code", type="string", length=255, nullable=true)
     */
    private $zipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=255, nullable=true)
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=255, nullable=true)
     */
    private $fax;

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
     * @return Website
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
     * @return Website
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
     * Set httpUrl
     *
     * @param string $httpUrl
     *
     * @return Website
     */
    public function setHttpUrl($httpUrl) {
        $this->httpUrl = $httpUrl;

        return $this;
    }

    /**
     * Get httpUrl
     *
     * @return string
     */
    public function getHttpUrl() {
        return $this->httpUrl;
    }

    /**
     * Set httpsUrl
     *
     * @param string $httpsUrl
     *
     * @return Website
     */
    public function setHttpsUrl($httpsUrl) {
        $this->httpsUrl = $httpsUrl;

        return $this;
    }

    /**
     * Get httpsUrl
     *
     * @return string
     */
    public function getHttpsUrl() {
        return $this->httpsUrl;
    }

    /**
     * Set icpNum
     *
     * @param string $icpNum
     *
     * @return Website
     */
    public function setIcpNum($icpNum) {
        $this->icpNum = $icpNum;

        return $this;
    }

    /**
     * Get icpNum
     *
     * @return string
     */
    public function getIcpNum() {
        return $this->icpNum;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Website
     */
    public function setAddress($address) {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     *
     * @return Website
     */
    public function setZipCode($zipCode) {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode() {
        return $this->zipCode;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Website
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return Website
     */
    public function setTel($tel) {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel() {
        return $this->tel;
    }

    /**
     * Set fax
     *
     * @param string $fax
     *
     * @return Website
     */
    public function setFax($fax) {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax() {
        return $this->fax;
    }

}
