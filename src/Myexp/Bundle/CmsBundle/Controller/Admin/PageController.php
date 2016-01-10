<?php

namespace Myexp\Bundle\CmsBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\CmsBundle\Entity\Page;
use Myexp\Bundle\CmsBundle\Form\PageType;

/**
 * Page controller.
 *
 * @Route("/admin/page")
 */
class PageController extends AdminController {

    /**
     *
     * 主菜单
     * 
     * @var type 
     */
    protected $primaryMenu = 'admin_page';

    /**
     * 主实体
     * 
     * @var type 
     */
    protected $primaryEntity = 'Page';
    
    /**
     * 主表单类型
     *
     * @var type 
     */
    protected $primaryFormType = PageType::class;

    /**
     * Lists all Page entities.
     *
     * @Route("/", name="admin_page")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        return $this->index();
    }

    /**
     * Creates a new Page entity.
     *
     * @Route("/", name="admin_page_create")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("POST")
     * @Template("MyexpCmsBundle:Admin/Page:new.html.twig")
     */
    public function createAction(Request $request) {

        $entity = new Page();
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
                    'form' => $form->createView()
        ));
    }

    /**
     * Displays a form to create a new Page entity.
     *
     * @Route("/new", name="admin_page_new")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {

        $entity = new Page();

        $form = $this->createCreateForm($entity);

        return $this->display(array(
                    'entity' => $entity,
                    'form' => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Page entity.
     *
     * @Route("/{id}/edit", name="admin_page_edit")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Page')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->display(array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Edits an existing Page entity.
     *
     * @Route("/{id}", name="admin_page_update")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("PUT")
     * @Template("MyexpCmsBundle:Admin/Page:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Page')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->flush();

            return $this->redirectSuccess();
        }

        return $this->display(array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Page entity.
     *
     * @Route("/{id}", name="admin_page_delete")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyexpCmsBundle:Page')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Page entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirectSucceed();
    }

}
