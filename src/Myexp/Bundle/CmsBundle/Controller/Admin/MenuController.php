<?php

namespace Myexp\Bundle\CmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\CmsBundle\Entity\Menu;
use Myexp\Bundle\CmsBundle\Entity\MenuTranslation;
use Myexp\Bundle\CmsBundle\Form\MenuType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Menu controller.
 *
 * @Route("/menu")
 */
class MenuController extends Controller {

    /**
     * Lists all Menu entities.
     *
     * @Route("/", name="menu")
     * @Secure(roles="ROLE_ADMIN_USER")
     * @Method("GET|DELETE")
     * @Template()
     */
    public function indexAction() {

        $entities = array();
        $this->getMenuByRecursive($entities);

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Get menus recursively
     * 
     * @access private
     */
    private function getMenuByRecursive(&$result, $parent = null, $depth = 0) {

        $em = $this->getDoctrine()->getManager();

        if ($parent instanceof Menu) {
            $prefix = '';
            for ($i = 1; $i < $depth; $i++) {
                $prefix .= '|------';
            }
            $parent->getTrans()->setTitle($prefix . ' ' . $parent->getTrans()->getTitle());
            $result[] = $parent;
        }

        $entities = $em->getRepository('MyexpCmsBundle:Menu')->getChildren($parent);

        foreach ($entities as $menu) {
            $this->getMenuByRecursive($result, $menu, $depth + 1);
        }
    }

    /**
     * Save menu orders.
     *
     * @Route("/order", name="menu_order")
     * @Secure(roles="ROLE_ADMIN_USER")
     * @Method("POST")
     */
    public function sortOrderAction() {

        $em = $this->getDoctrine()->getManager();
        $menuRepo = $em->getRepository('MyexpCmsBundle:menu');

        $orders = $this->getRequest()->request->get('orders');

        foreach ($orders as $id => $order) {
            $menu = $menuRepo->find($id);
            $menu->setSortOrder($order);
            $em->persist($menu);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('notice', 'common.success');

        return $this->redirect($this->generateUrl('menu'));
    }

    /**
     * Creates a new Menu entity.
     *
     * @Route("/", name="menu_create")
     * @Secure(roles="ROLE_ADMIN_USER")
     * @Method("POST")
     * @Template("MyexpCmsBundle:Menu:new.html.twig")
     */
    public function createAction(Request $request) {

        $entity = new Menu();
        $form = $this->createForm(new MenuType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'common.success');

            return $this->redirect($this->generateUrl('menu_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Menu entity.
     *
     * @Route("/new", name="menu_new")
     * @Secure(roles="ROLE_ADMIN_USER")
     * @Method("GET|POST")
     * @Template()
     */
    public function newAction() {

        $entity = new Menu();
        $languages = $this->container->getParameter('languages');

        foreach (array_keys($languages) as $lang) {

            $translation = new MenuTranslation();
            $translation->setLang($lang);

            $entity->addTranslation($translation);
        }

        $form = $this->createForm(new MenuType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Menu entity.
     *
     * @Route("/{id}", name="menu_show")
     * @Secure(roles="ROLE_ADMIN_USER")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Menu entity.
     *
     * @Route("/{id}/edit", name="menu_edit")
     * @Secure(roles="ROLE_ADMIN_USER")
     * @Method("GET|DELETE")
     * @Template()
     */
    public function editAction($id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MyexpCmsBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $editForm = $this->createForm(new MenuType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Menu entity.
     *
     * @Route("/{id}", name="menu_update")
     * @Secure(roles="ROLE_ADMIN_USER")
     * @Method("PUT")
     * @Template("MyexpCmsBundle:Menu:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new MenuType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'common.success');

            return $this->redirect($this->generateUrl('menu_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Menu entity.
     *
     * @Route("/{id}", name="menu_delete")
     * @Secure(roles="ROLE_ADMIN_USER")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {

        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyexpCmsBundle:Menu')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Menu entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('menu'));
    }

    /**
     * Render current menu
     *
     * @Route("/render", name="menu_render")
     * @Method("GET")
     * @Template()
     */
    public function renderAction() {

        $em = $this->getDoctrine()->getManager();
        $ep = $em->getRepository('MyexpCmsBundle:Menu');

        $topMenus = $ep->getChildren();

        $menus = array();
        foreach ($topMenus as $topMenu) {

            $menu = $this->getLink($topMenu);
            $children = $ep->getChildren($topMenu);

            if ($children) {
                foreach ($children as $child) {
                    $childMenu = $this->getLink($child);
                    if ($childMenu['current']) {
                        $menu['current'] = $childMenu['current'];
                    }
                    $menu['children'][] = $childMenu;
                }
            }

            $menus[] = $menu;
        }

        return array(
            'navMenus' => $menus
        );
    }

    /**
     * Get menu link
     */
    private function getLink($menu) {

        $path = $menu->getPath();
        if (preg_match('/^http/', $path)) {
            $link = $path;
        } else {
            $link = $this->getRequest()->getBaseUrl() . $path;
        }

        $pathInfo = Request::createFromGlobals()->getPathInfo();

        return array(
            'title' => $menu->getTrans()->getTitle(),
            'link' => $link,
            'current' => $path == $pathInfo ? true : false,
            'children' => null
        );
    }

    /**
     * Creates a form to delete a Menu entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

    /**
     * Render current menu
     *
     * @Route("/service", name="menu_service")
     * @Method("GET")
     * @Template()
     */
    public function serviceAction($parent) {

        $em = $this->getDoctrine()->getManager();
        $Menus = $em->getRepository('MyexpCmsBundle:Menu')->getService(8, $parent);
        if (empty($Menus)) {
            echo "no result in index";
            exit();
        } else {
            foreach ($Menus as $Menu) {
                $a = $this->getLink($Menu);
                $services[] = $a;
            }
            return array(
                'services' => $services
            );
        }
    }

}
