<?php

namespace Myexp\Bundle\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\AdminBundle\Entity\Website;
use Myexp\Bundle\AdminBundle\Form\WebsiteType;

/**
 * Website controller.
 *
 * @Route("/website")
 */
class WebsiteController extends AdminController {

    /**
     *  主实体
     * 
     * @var type 
     */
    protected $primaryEntity = 'Website';

    /**
     * 主表单类型
     *
     * @var type 
     */
    protected $primaryFormType = WebsiteType::class;

    /**
     * Lists all Website entities.
     *
     * @Route("/", name="admin_website")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $pagination = $this->getPagination();

        return $this->display(array(
                    'pagination' => $pagination
        ));
    }

    /**
     * Creates a new Website entity.
     *
     * @Route("/", name="admin_website_create")
     * @Method("POST")
     * @Template("MyexpAdminBundle:Admin/Website:new.html.twig")
     */
    public function createAction(Request $request) {

        $entity = new Website();
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
            'form' => $form->createView()
        );
    }

    /**
     * Displays a form to create a new Website entity.
     *
     * @Route("/new", name="admin_website_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {

        $entity = new Website();
        $form = $this->createCreateForm($entity);

        return $this->display(array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Website entity.
     *
     * @Route("/{id}", name="admin_website_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpAdminBundle:Website')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Website entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Website entity.
     *
     * @Route("/{id}/edit", name="admin_website_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpAdminBundle:Website')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Website entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->display(array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Website entity.
     *
     * @Route("/{id}", name="admin_website_update")
     * @Method("PUT")
     * @Template("MyexpAdminBundle:Admin/Website:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpAdminBundle:Website')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Website entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
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
     * Deletes a Website entity.
     *
     * @Route("/{id}", name="admin_website_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyexpAdminBundle:Website')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Website entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirectSucceed();
    }

}
