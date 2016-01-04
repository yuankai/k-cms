<?php

namespace Myexp\Bundle\CmsBundle\Routing;

use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Myexp\Bundle\CmsBundle\Repository\ContentModel;

/**
 * Description of RewriteLoader
 *
 * @author kai
 */
class RewriteLoader extends Loader {

    /**
     *
     * @var type 
     */
    private $loaded = false;

    /**
     *
     * @var type 
     */
    protected $rewrite;

    /**
     *
     * @var type 
     */
    protected $registry;

    /**
     * 
     * @param RegistryInterface $registry
     * @param type $rewrite
     */
    public function __construct(RegistryInterface $registry, $rewrite) {
        $this->registry = $registry;
        $this->rewrite = $rewrite;
    }

    /**
     * 
     * @param type $resource
     * @param type $type
     */
    public function load($resource, $type = null) {

        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add the "rewrite" loader twice');
        }

        $routes = new RouteCollection();

        if ($this->rewrite['on']) {
            $this->loadContentModelDefaultRoute($routes);
            $this->loadUrlAliasRoute($routes);
        }

        $this->loaded = true;

        return $routes;
    }

    /**
     * 获得实体默认路由
     */
    private function loadContentModelDefaultRoute(RouteCollection $routes) {

        $contentModels = $this->rewrite['content_models'];
        if ($contentModels) {

            $em = $this->registry->getEntityManager();
            foreach ($contentModels as $contentModel) {
                $rep = $em->getRepository('MyexpCmsBundle:' . $contentModel);

                if ($rep instanceof ContentModel) {
                    $defaultRoutes = $rep->getDefaultRoute($this->rewrite['url_surffix']);
                    $routes->addCollection($defaultRoutes);
                }
            }
        }
    }

    /**
     * 从UrlAlias实体加载特定的路由
     */
    private function loadUrlAliasRoute(RouteCollection $routes) {

        $em = $this->registry->getEntityManager();
        $urlAliasRepo = $em->getRepository("MyexpCmsBundle:UrlAlias");

        $urlAliases = $urlAliasRepo->findAll();
        foreach ($urlAliases as $urlAlias) {
            $path = $urlAlias->getUrl();
            $defaults = array(
                '_controller' => 'MyexpCmsBundle:' . $urlAlias->getController()
            );
            $parameters = $urlAlias->getParameters();

            $requirements = array();
            $route = new Route($path, array_merge($defaults, $parameters), $requirements);

            $routeName = 'rewriteRoute' . $urlAlias->getId();
            $routes->add($routeName, $route);
        }
    }

    /**
     * 
     * @param type $resource
     * @param type $type
     * @return type
     */
    public function supports($resource, $type = null) {
        return 'rewrite' === $type;
    }

}
