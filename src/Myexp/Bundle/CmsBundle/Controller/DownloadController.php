<?php

namespace Myexp\Bundle\CmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Myexp\Bundle\CmsBundle\Entity\Download;
use Myexp\Bundle\CmsBundle\Form\DownloadType;

/**
 * Download controller.
 *
 * @Route("/download")
 */
class DownloadController extends CmsController {

    /**
     * 主实体
     * @var type 
     */
    protected $primaryEntity = 'Download';

    /**
     * 主表单类型
     *
     * @var type 
     */
    protected $primaryFormType = DownloadType::class;

    /**
     * Lists all Download entities.
     *
     * @Route("/", name="cms_download")
     * @Security("has_role('ROLE_ADMIN')")
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
     * Creates a new Download entity.
     *
     * @Route("/", name="cms_download_create")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("POST")
     * @Template("MyexpCmsBundle:Download:new.html.twig")
     */
    public function createAction(Request $request) {

        $entity = new Download();
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
     * Displays a form to create a new Download entity.
     *
     * @Route("/new", name="cms_download_new")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET|POST")
     * @Template()
     */
    public function newAction() {

        $entity = new Download();

        $entity->setIsDirectDownload(true);
        $entity->setPublishTime(new \DateTime());
        $form = $this->createCreateForm($entity);

        return $this->display(array(
                    'entity' => $entity,
                    'form' => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Download entity.
     *
     * @Route("/{id}/edit", name="cms_download_edit")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MyexpCmsBundle:Download')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Download entity.');
        }

        $editForm = $this->createCreateForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->display(array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Download entity.
     *
     * @Route("/{id}", name="cms_download_update")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("PUT")
     * @Template("MyexpCmsBundle:Download:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Download')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Download entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->bind($request);

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
     * Deletes a Download entity.
     *
     * @Route("/{id}", name="cms_download_delete")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyexpCmsBundle:Download')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Download entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirectSucceed();
    }

}
