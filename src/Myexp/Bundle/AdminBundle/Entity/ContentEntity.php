<?php

namespace Myexp\Bundle\AdminBundle\Entity;

/**
 * 内容实体
 */
abstract class ContentEntity {

    /**
     * 魔术方法用来读取内容属性
     * 
     * @param type $name
     * @param type $arguments
     */
    function __call($name, $arguments) {
        
        $content = $this->getContent();
        $method = 'get'.ucfirst($name);
        
        if(property_exists(Content::class, $name)){
            return call_user_method($method, $content, $arguments);
        } elseif(method_exists($content, $method)) {
            return $content->$method($arguments);
        }
        
        return null;
    }

    /**
     * 获得内容实体
     */
    abstract function getContent();
}
