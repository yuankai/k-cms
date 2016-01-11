<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UrlAlias
 *
 * @ORM\Table(name="content_models")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Repository\ContentModelRepository")
 */
class ContentModel {

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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="entity_name", type="string", length=255)
     */
    private $entityName;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_classable", type="boolean", nullable=true)
     */
    private $isClassable;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get name
     * 
     * @return type
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set name
     * 
     * @param type $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Get title
     * 
     * @return type
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set title
     * 
     * @param type $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * 
     * Get entity name
     * 
     * @return type
     */
    public function getEntityName() {
        return $this->entityName;
    }

    /**
     * Set entity name
     * 
     * @param type $entityName
     */
    public function setEntityName($entityName) {
        $this->entityName = $entityName;
    }

    /**
     * 
     * Get is classable
     * 
     * @return type
     */
    public function getIsClassable() {
        return $this->isClassable;
    }

    /**
     * set is classable
     * 
     * @param type $isClassable
     */
    public function setIsClassable($isClassable) {
        $this->isClassable = $isClassable;
    }

}
