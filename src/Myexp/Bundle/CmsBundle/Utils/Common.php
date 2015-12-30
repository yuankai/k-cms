<?php

namespace Myexp\Bundle\CmsBundle\Helper;

use Symfony\Component\Finder\Finder;

class Common {

    public static function buildTree($entities, $top = 0, $depth = 0) {

        $all_entities = $sub_entities = array();

        foreach ($entities as $entity) {
            if ($entity->getPid() == $top) {
                $sub_entities[] = $entity;
            }
        }

        if (count($sub_entities) > 0) {

            foreach ($sub_entities as $sub_entity) {

                $prefix = '';
                for ($i = 0; $i < $depth; $i++) {
                    if ($i == 0) {
                        $prefix .= '&nbsp;|';
                    }
                    $prefix .= '--';
                }

                $localeTrans = $sub_entity->getTrans();

                $all_entities[] = array(
                    'id' => $sub_entity->getId(),
                    'title' => $prefix . $localeTrans->getTitle()
                );

                $tmp_entities = self::buildTree($entities, $sub_entity->getId(), $depth + 1);

                $all_entities = array_merge($all_entities, $tmp_entities);
            }
        }

        return $all_entities;
    }

    /**
     * 创建目录树
     * 
     * @static
     * @access public
     */
    public static function buildDirTree($path) {

        $finder = new Finder();
        $finder->directories()->in($path)->depth('== 0');

        $nodes = array();
        foreach ($finder as $dir) {

            $node = array(
                'id' => $dir->getPathName(),
                'label' => $dir->getFileName()
            );

            $children = self::buildDirTree($dir->getPathName());
            if ($children) {
                $node['children'] = $children;
            }

            $nodes[] = $node;
        }

        return $nodes;
    }

    /**
     * 合并分类和页面
     * 
     * @static
     * @access public
     */
    public static function combieCategoryAndPages($categories, $pages) {

        $sortAble = array_merge($categories->toArray(), $pages->toArray());

        usort($sortAble, function($a, $b) {

            $sortOrderA = $a->getSortOrder();
            $sortOrderB = $b->getSortOrder();

            if ($sortOrderA == $sortOrderB) {
                return 0;
            }

            return ($sortOrderA > $sortOrderB) ? -1 : 1;
        });

        return $sortAble;
    }

}
