<?php

namespace Myexp\Bundle\CmsBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\CmsBundle\Entity\Menu;
use Myexp\Bundle\CmsBundle\Form\MenuType;

/**
 * Menu controller.
 *
 * @Route("/admin/menu")
 */
class MenuController extends AdminController {

    /**
     *
     * 主菜单
     * 
     * @var type 
     */
    protected $primaryMenu = 'admin_menu';

    /**
     * 主实体
     * @var type 
     */
    protected $primaryEntity = 'Menu';

    /**
     * 主表单类型
     *
     * @var type 
     */
    protected $primaryFormType = MenuType::class;

    /**
     * Lists all Menu entities.
     *
     * @Route("/", name="admin_menu")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        return $this->index();
    }

    /**
     * Creates a new Menu entity.
     *
     * @Route("/", name="admin_menu_create")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("POST")
     * @Template("MyexpCmsBundle:Admin/Menu:new.html.twig")
     */
    public function createAction(Request $request) {

        $entity = new Menu();

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirectSucceed();
        }

        return $this->display(array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Menu entity.
     *
     * @Route("/new", name="admin_menu_new")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET|POST")
     * @Template()
     */
    public function newAction() {

        $entity = new Menu();
        $entity->setWebsite($this->currentWebsite);

        $form = $this->createCreateForm($entity);

        return $this->display(array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Menu entity.
     *
     * @Route("/{id}/edit", name="admin_menu_edit")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET|DELETE")
     * @Template()
     */
    public function editAction($id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MyexpCmsBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        //top menu items
        $topItems = $em
                ->getRepository('MyexpCmsBundle:MenuItem')
                ->findBy(
                array(
                    'menu' => $entity,
                    'parent' => null
                ))
        ;

        return $this->display(array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                    'topItems' => $topItems
        ));
    }

    /**
     * Edits an existing Menu entity.
     *
     * @Route("/{id}", name="admin_menu_update")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("PUT")
     * @Template("MyexpCmsBundle:Admin/Menu:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Menu entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $em->persist($entity);
            $em->flush();

            return $this->redirectSucceed();
        }

        return $this->display(array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Menu entity.
     *
     * @Route("/{id}", name="admin_menu_delete")
     * @Security("has_role('ROLE_ADMIN')")
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

        return $this->redirectSucceed();
    }

}
