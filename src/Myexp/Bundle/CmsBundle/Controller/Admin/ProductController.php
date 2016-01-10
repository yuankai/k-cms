<?php

namespace Myexp\Bundle\CmsBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\CmsBundle\Entity\Product;
use Myexp\Bundle\CmsBundle\Form\ProductType;

/**
 * Product controller.
 *
 * @Route("/admin/product")
 */
class ProductController extends AdminController {

    /**
     *
     * 主菜单
     * 
     * @var type 
     */
    protected $primaryMenu = 'admin_product';

    /**
     * 主实体
     * @var type 
     */
    protected $primaryEntity = 'Product';

    /**
     * 主表单类型
     *
     * @var type 
     */
    protected $primaryFormType = ProductType::class;

    /**
     * Lists all Product entities.
     *
     * @Route("/", name="admin_product")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        return $this->index();
    }

    /**
     * Creates a new Product entity.
     *
     * @Route("/", name="admin_product_create")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("POST")
     * @Template("MyexpCmsBundle:Admin/Product:new.html.twig")
     */
    public function createAction(Request $request) {

        $entity = new Product();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirectSucceed();
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Product entity.
     *
     * @Route("/new", name="admin_product_new")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET|POST")
     * @Template()
     */
    public function newAction() {

        $entity = new Product();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     * @Route("/{id}/edit", name="admin_product_edit")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET|DELETE")
     * @Template()
     */
    public function editAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Product entity.
     *
     * @Route("/{id}", name="admin_product_update")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("PUT")
     * @Template("MyexpCmsBundle:Product:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $em->persist($entity);
            $em->flush();

            return $this->redirectSucceed();
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Product entity.
     *
     * @Route("/{id}", name="admin_product_delete")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyexpCmsBundle:Product')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Product entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirectSucceed();
    }
}
