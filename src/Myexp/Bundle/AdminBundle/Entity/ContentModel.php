<?php

namespace Myexp\Bundle\AdminBundle\Entity;

use Symfony\Component\Routing\Route;
use Doctrine\ORM\Mapping as ORM;

/**
 * ContentModel
 *
 * @ORM\Table(name="content_models")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\AdminBundle\Repository\ContentModelRepository")
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
     * @var string
     *
     * @ORM\Column(name="list_controller_name", type="string", length=255)
     */
    private $listControllerName;

    /**
     * @var string
     *
     * @ORM\Column(name="show_controller_name", type="string", length=255)
     */
    private $showControllerName;

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
     * Get list controller name
     * 
     * @return type
     */
    public function getListControllerName() {
        return $this->listControllerName;
    }

    /**
     * Set list controller name
     * 
     * @param type $listControllerName
     */
    public function setListControllerName($listControllerName) {
        $this->listControllerName = $listControllerName;
    }

    /**
     * 
     * Get show controller name
     * 
     * @return type
     */
    public function getShowControllerName() {
        return $this->showControllerName;
    }

    /**
     * Set show controller name
     * 
     * @param type $showControllerName
     */
    public function setShowControllerName($showControllerName) {
        $this->showControllerName = $showControllerName;
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

    /**
     * 获得列表路由
     * 
     * @return type
     */
    public function getDefaultListRoute($withPage = true) {
        return $this->getDefaultRoute('list', $withPage);
    }

    /**
     * 获得查看路由
     * 
     * @return type
     */
    public function getDefaultShowRoute($withPage = true) {
        return $this->getDefaultRoute('show', $withPage);
    }

    /**
     * 
     * 获得默认路由
     * 
     * @param type $action
     * @param type $withPage
     * @return Route
     */
    public function getDefaultRoute($action, $withPage = true) {

        //默认路径
        $path = $this->getDefaultPath($action, '{id}', $withPage, '{page}');

        //路由
        if ('list' == $action) {
            
            //不能分类的内容
            if(!$this->getIsClassable()){
                return null;
            }
            
            $controller = $this->getListControllerName();
        } else {
            $controller = $this->getShowControllerName();
        }

        $defaults = array(
            '_controller' => $controller,
            'model' => $this->getName(),
            'page' => 1
        );
        $requirements = array(
            'id' => '\d+',
            'page' => '\d+'
        );

        return new Route($path, $defaults, $requirements);
    }

    /**
     * 获得列表路径
     * 
     * @return type
     */
    public function getDefaultListPath($withPage = true) {
        return $this->getDefaultPath('list', '{id}', $withPage, '{page}');
    }

    /**
     * 获得查看路径
     * 
     * @return type
     */
    public function getDefaultShowPath($withPage = true) {
        return $this->getDefaultPath('show', '{id}', $withPage, '{page}');
    }

    /**
     * 获得路径
     * 
     * @return type
     */
    public function getDefaultPath($action, $id, $withPage = true, $page = 1) {

        $path = '/' . $this->getName() . '/' . $action . '/' . $id;

        if ($withPage) {
            $path .= ('-' . $page);
        }

        return $path;
    }

}
