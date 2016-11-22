<?php

namespace Myexp\Bundle\FrontBundle\Twig;

/**
 * 前台扩展twig功能
 *
 * @author Kevin
 */
class FrontFunctions {

    /**
     *
     * @var FrontExtension
     */
    protected $ext;

    /**
     * 
     * @param FrontExtension $ext
     */
    public function __construct(FrontExtension $ext) {
        $this->ext = $ext;
    }

    /**
     * 获得路径
     * 
     * @param type $var
     */
    public function getFrontUrl($path, $page = 1) {

        $router = $this->ext->getRouter();
        $route = $router->match($path);

        if (!$route['_route']) {
            return '';
        }

        $rewriteConfig = $this->ext->getRewriteConfig();

        $id = $route['id'];
        $routeName = $route['_route'];

        $testSuffix = array(
            '_p_r_' . $id, '_p_' . $id, '_p_r', '_p',
            '_r_' . $id, '_' . $id, '_r'
        );

        //根据配置过滤可匹配的路径
        foreach ($testSuffix as $i => $suffix) {

            //分页首页且不显示在url中
            if ($page == 1 && (!$rewriteConfig['page_in_first_link'])) {
                if (preg_match('/_p/', $suffix)) {
                    unset($testSuffix[$i]);
                }
            }

            //关闭重写，过滤所有rewrite url
            if (!$rewriteConfig['on']) {
                if (preg_match('/_r/', $suffix)) {
                    unset($testSuffix[$i]);
                }
            }
        }

        $routeCollection = $router->getRouteCollection();
        foreach ($testSuffix as $suffix) {
            $newRouteName = $routeName . $suffix;
            $matchRoute = $routeCollection->get($newRouteName);
            if ($matchRoute) {
                return $router->generate($newRouteName, array(
                            'id' => $id,
                            'page' => $page
                ));
            }
        }

        return $path;
    }

    /**
     * 获得菜单项
     * 
     * @param mixed $var
     */
    public function getMenuItems($var) {

        $em = $this->ext->getManager();

        if (is_string($var)) {

            $menu = $em
                    ->getRepository('MyexpAdminBundle:Menu')
                    ->findOneBy(array('name' => $var, 'isActive'=>true))
            ;

            return $em
                            ->getRepository('MyexpAdminBundle:MenuItem')
                            ->findBy(array(
                                'menu' => $menu,
                                'parent' => null,
                                'isActive'=>true
                                    ), array(
                                'sequenceId' => 'ASC'
                            ))
            ;
        }

        //get children
        if (is_object($var)) {
            return $em
                            ->getRepository('MyexpAdminBundle:MenuItem')
                            ->findBy(array('parent' => $var, 'isActive'=>true))
            ;
        }
    }

    /**
     * 获得节点
     * 
     * @param mixed $var
     */
    public function getNodes($var) {

        $em = $this->ext->getManager();

        if (is_string($var)) {

            $currNode = $em
                    ->getRepository('MyexpAdminBundle:Node')
                    ->findOneBy(array('path' => $var, 'isActive'=>true))
            ;

            if ($currNode) {
                return $currNode->getTopNode();
            }
        }

        //get children
        if (is_object($var)) {
            return $em
                            ->getRepository('MyexpAdminBundle:Node')
                            ->findBy(array('parent' => $var, 'isActive'=>true))
            ;
        }
    }

    /**
     * 获得分类
     * 
     * @param mixed $var
     */
    public function getCategories($var) {

        $em = $this->ext->getManager();

        if (is_string($var)) {

            $contentModel = $em
                    ->getRepository('MyexpAdminBundle:ContentModel')
                    ->findOneBy(array('name' => $var))
            ;

            $categories = $em
                    ->getRepository('MyexpAdminBundle:Category')
                    ->findBy(array(
                        'contentModel' => $contentModel,
                        'parent' => null, 
                        'isActive'=>true
                    ))
            ;

            return $categories;
        }

        //get children
        if (is_object($var)) {
            return $em
                            ->getRepository('MyexpAdminBundle:Category')
                            ->findBy(array('parent' => $var, 'isActive'=>true))
            ;
        }
    }

    /**
     * 获得幻灯片
     * 
     * @param mixed $var
     */
    public function getSliders($var) {

        $em = $this->ext->getManager();

        if (is_string($var)) {

            $slider = $em
                    ->getRepository('MyexpAdminBundle:Slider')
                    ->findOneBy(array('name' => $var, 'isActive'=>true))
            ;

            return $slider;
        }

        //get children
        if (is_object($var)) {
            return $em
                            ->getRepository('MyexpAdminBundle:SliderPhoto')
                            ->findBy(array('slider' => $var, 'isActive'=>true))
            ;
        }
    }

    /**
     * 获得产品
     * 
     * @param type $categoryId
     * @param type $limit
     * @param type $featured
     * @param type $stick
     * @return type
     */
    public function getProducts($categoryId = null, $limit = null, $featured = null, $stick = null) {

        $qb = $this->getContentQuery('MyexpCmsBundle:Product', $categoryId, $limit, $featured, $stick);

        $query = $qb->getQuery();

        return $query->getResult();
    }

    /**
     * 获得文章
     * 
     * @param type $categoryId
     * @param type $limit
     * @param type $featured
     * @param type $stick
     * @return type
     */
    public function getArticles($categoryId = null, $limit = null, $featured = null, $stick = null) {

        $qb = $this->getContentQuery('MyexpCmsBundle:Article', $categoryId, $limit, $featured, $stick);

        $query = $qb->getQuery();

        return $query->getResult();
    }

    /**
     * 获得内容查询QueryBuilder
     * 
     * @param type $entity
     * @param type $categoryId
     * @param type $limit
     * @param type $featured
     * @param type $stick
     * @return type
     */
    private function getContentQuery($entity, $categoryId = null, $limit = null, $featured = null, $stick = null) {

        $em = $this->ext->getManager();

        $qb = $em
                ->getRepository($entity)
                ->createQueryBuilder('q')
        ;

        //分类
        if ($categoryId) {

            $categoryRep = $em->getRepository('MyexpAdminBundle:Category');

            if (is_string($categoryId)) {
                $category = $categoryRep
                        ->createQueryBuilder('c')
                        ->join('c.urlAlias', 'ua')
                        ->where('ua.url = :url')
                        ->setParameter('url', $categoryId)
                        ->getQuery()
                        ->getSingleResult()
                ;
            } else {
                $category = $categoryRep->find($categoryId);
            }

            $qb
                    ->where('q.category = :category')
                    ->setParameter('category', $category)
            ;
        }

        //特色
        if ($featured) {
            $qb
                    ->where($qb->expr()->isNotNull('q.featuredOrder'))
                    ->orderBy('q.featuredOrder', 'ASC')
            ;
        }

        //置顶
        if ($stick) {
            $qb
                    ->where($qb->expr()->isNotNull('q.stickOrder'))
                    ->orderBy('q.featuredOrder', 'ASC')
            ;
        }

        //限制数量
        if ($limit) {
            $qb->setMaxResults($limit);
        }

        return $qb;
    }

    /**
     * 获得页面
     * 
     * @param type $var
     */
    public function getPage($var) {

        $em = $this->ext->getManager();

        $qb = $em
                ->getRepository('MyexpCmsBundle:Page')
                ->createQueryBuilder('p')
        ;

        $qb
                ->join('p.content', 'c')
                ->join('c.urlAlias', 'ua')
                ->where('ua.url = :url')
                ->setParameter('url', $var)
        ;

        return $qb
                        ->getQuery()
                        ->getOneOrNullResult()
        ;
    }

}
