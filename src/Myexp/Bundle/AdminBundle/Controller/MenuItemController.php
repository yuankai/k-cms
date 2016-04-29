<?php

namespace Myexp\Bundle\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\AdminBundle\Entity\MenuItem;
use Myexp\Bundle\AdminBundle\Form\MenuItemType;

/**
 * MenuItem controller.
 *
 * @Route("/menuitem")
 */
class MenuItemController extends AdminController {

    /**
     * 主实体
     * @var type 
     */
    protected $primaryEntity = 'MenuItem';

    /**
     * 主表单类型
     *
     * @var type 
     */
    protected $primaryFormType = MenuItemType::class;

    /**
     * Creates a new MenuItem entity.
     *
     * @Route("/", name="admin_menuitem_create")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("POST")
     */
    public function createAction(Request $request) {

        $entity = new MenuItem();

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->ajaxDisplay(array(
                        'id' => $entity->getId(),
                        'title' => $entity->getTitle()
            ));
        }

        $errors = $form->getErrors(true);

        return $this->ajaxDisplay(array('errors' => $errors));
    }

    /**
     * Creates a new MenuItem entity.
     *
     * @Route("/new", name="admin_menuitem_new")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function newAction(Request $request) {

        $menuItem = new MenuItem();
        $menuItem->setIsActive(true);

        //所属菜单
        $menuId = $request->get('menuId');
        $menu = $this
                ->getDoctrine()
                ->getRepository('MyexpAdminBundle:Menu')
                ->find($menuId)
        ;
        $menuItem->setMenu($menu);

        //上级节点
        $parentId = $request->get('parentId');
        if ($parentId) {
            $parent = $this
                    ->getDoctrine()
                    ->getRepository('MyexpAdminBundle:MenuItem')
                    ->find($parentId)
            ;
            $menuItem->setParent($parent);
        }

        $form = $this->createCreateForm($menuItem, false);

        return $this->display(array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a MenuItem entity.
     *
     * @Route("/{id}", name="admin_menuitem_show")
     * @Method("GET")
     */
    public function showAction(MenuItem $menuItem) {
        $deleteForm = $this->createDeleteForm($menuItem);

        return $this->render('menuitem/show.html.twig', array(
                    'menuItem' => $menuItem,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing MenuItem entity.
     *
     * @Route("/{id}/edit", name="admin_menuitem_edit")
     * @Method({"GET"})
     * @Template()
     */
    public function editAction(Request $request, MenuItem $menuItem) {

        $editForm = $this->createEditForm($menuItem, false);
        $editForm->handleRequest($request);

        return $this->display(array(
                    'edit_form' => $editForm->createView()
        ));
    }

    /**
     * Edits an existing Menu entity.
     *
     * @Route("/{id}", name="admin_menuitem_update")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("PUT")
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpAdminBundle:MenuItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MenuItem entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $em->persist($entity);
            $em->flush();

            return $this->ajaxDisplay(array(
                        'id' => $entity->getId(),
                        'title' => $entity->getTitle()
            ));
        }

        $errors = $editForm->getErrors(true);

        return $this->ajaxDisplay(array('errors' => $errors));
    }

    /**
     * Deletes a MenuItem entity.
     *
     * @Route("/{id}", name="admin_menuitem_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MenuItem $menuItem) {
        
        $form = $this->createDeleteForm($menuItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($menuItem);
            $em->flush();
        }

        return $this->redirectToRoute('menuitem_index');
    }

}
