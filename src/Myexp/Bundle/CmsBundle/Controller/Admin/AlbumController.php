<?php

namespace Myexp\Bundle\CmsBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\CmsBundle\Entity\Album;
use Myexp\Bundle\CmsBundle\Form\AlbumType;

/**
 * Album controller.
 *
 * @Route("/admin/album")
 */
class AlbumController extends AdminController {

    /**
     *
     * 主菜单
     * 
     * @var type 
     */
    protected $primaryMenu = 'admin_album';

    /**
     * 主实体
     * @var type 
     */
    protected $primaryEntity = 'Album';

    /**
     * 主表单类型
     *
     * @var type 
     */
    protected $primaryFormType = AlbumType::class;

    /**
     * Lists all Album entities.
     *
     * @Route("/", name="admin_album")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        return $this->index();
    }

    /**
     * Creates a new Album entity.
     *
     * @Route("/", name="admin_album_create")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("POST")
     * @Template("MyexpCmsBundle:Album:new.html.twig")
     */
    public function createAction(Request $request) {

        $entity = new Album();
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
     * Displays a form to create a new Album entity.
     *
     * @Route("/new", name="admin_album_new")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {

        $entity = new Album();

        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Album entity.
     *
     * @Route("/{id}/edit", name="admin_album_edit")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Album')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
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
     * Edits an existing Album entity.
     *
     * @Route("/{id}", name="admin_album_update")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("PUT")
     * @Template("MyexpCmsBundle:Album:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Album')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
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
     * Deletes a Album entity.
     *
     * @Route("/{id}", name="admin_album_delete")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyexpCmsBundle:Album')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Album entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirectSucceed();
    }

}
