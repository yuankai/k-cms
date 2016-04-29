<?php

namespace Myexp\Bundle\FrontBundle\Routing;

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
        $contentModels = $em->getRepository('MyexpAdminBundle:ContentModel')->findAll();
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

                        $routeNameSuffix = $page ? '_p' : '';
                        $routeNameSuffix .= $suffix ? '_r' : '';

                        $routeName = $modelName . '_' . $action . $routeNameSuffix;
                        $route = $contentModel->getDefaultRoute($action, $page);

                        if ($route == null) {
                            continue;
                        }

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

        $urlAliasRepo = $em->getRepository("MyexpAdminBundle:UrlAlias");
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

                $withSuffix = array(false);

                //伪静态
                if ($this->rewriteConfig['on']) {
                    $withSuffix[] = true;
                }

                //按照带不带后缀
                foreach ($withSuffix as $suffix) {

                    $newRoute = clone $defaultRoute;

                    $routeNameSuffix = $suffix ? '_r_' : '_';

                    $newRoute->setPath($routePath . ($suffix ? $urlSuffix : ''));
                    $newRoute->setDefault('id', $matchRes['id']);

                    $newRouteName = $routeName . $routeNameSuffix . $matchRes['id'];
                    $routes->add($newRouteName, $newRoute);
                }
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
