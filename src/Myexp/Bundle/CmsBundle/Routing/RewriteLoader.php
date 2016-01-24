<?php

namespace Myexp\Bundle\CmsBundle\Routing;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Bridge\Doctrine\RegistryInterface;

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
    private $registry;

    /**
     *
     * @var type 
     */
    private $rewriteConfig;

    /**
     * 
     * @param RegistryInterface $registry
     * @param type $rewriteConfig
     */
    public function __construct(RegistryInterface $registry, $rewriteConfig) {
        $this->registry = $registry;
        $this->rewriteConfig = $rewriteConfig;
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

        $this->loadContentModelDefaultRoute($routes);
        $this->loadUrlAliasRoute($routes);

        $this->loaded = true;

        return $routes;
    }

    /**
     * 获得实体默认路由
     */
    private function loadContentModelDefaultRoute(RouteCollection $routes) {

        $em = $this->registry->getManager();
        $contentModels = $em->getRepository('MyexpCmsBundle:ContentModel')->findAll();
        $urlSuffix = $this->rewriteConfig['url_suffix'];

        if (!$contentModels) {
            return;
        }

        foreach ($contentModels as $contentModel) {

            $modelName = $contentModel->getName();
            $actions = array('list', 'show');

            foreach ($actions as $action) {

                $withPage = array(false, true);
                $withSuffix = array(false);

                //伪静态
                if ($this->rewriteConfig['on']) {
                    $withSuffix[] = true;
                }

                foreach ($withPage as $page) {
                    foreach ($withSuffix as $suffix) {

                        $routeNameSuffix = $page ? '_page' : '';
                        $routeNameSuffix .= $suffix ? '_html' : '';

                        $routeName = $modelName . '_' . $action . $routeNameSuffix;
                        $route = $contentModel->getDefaultRoute($action, $page);

                        if ($suffix) {
                            $route->setPath($route->getPath() . $urlSuffix);
                        }

                        $routes->add($routeName, $route);
                    }
                }
            }
        }
    }

    /**
     * 从UrlAlias实体加载特定的路由
     */
    private function loadUrlAliasRoute(RouteCollection $routes) {

        $em = $this->registry->getManager();
        $request = Request::createFromGlobals();

        $urlSuffix = $this->rewriteConfig['url_suffix'];

        $context = new RequestContext();
        $context->fromRequest($request);

        $matcher = new UrlMatcher($routes, $context);

        $urlAliasRepo = $em->getRepository("MyexpCmsBundle:UrlAlias");
        $urlAliases = $urlAliasRepo->findAll();

        foreach ($urlAliases as $urlAlias) {

            $path = $urlAlias->getPath();
            $url = $urlAlias->getUrl();

            $pathes = array($path, $path . '-1');
            $routePathes = array($url, $url . '-{page}');

            foreach ($pathes as $i => $path) {

                $routePath = $routePathes[$i];

                try {
                    $matchRes = $matcher->match($path);
                } catch (ResourceNotFoundException $e) {
                    continue;
                }

                $routeName = $matchRes['_route'];
                $defaultRoute = $routes->get($routeName);

                $newRoute = clone $defaultRoute;

                $newRoute->setPath($routePath . $urlSuffix);
                $newRoute->setDefault('id', $matchRes['id']);

                $newRouteName = $routeName . '_' . $urlAlias->getId();
                $routes->add($newRouteName, $newRoute);
            }
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
