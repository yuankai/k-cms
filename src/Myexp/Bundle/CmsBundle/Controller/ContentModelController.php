<?php

namespace Myexp\Bundle\CmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Myexp\Bundle\CmsBundle\Entity\ContentModel;
use Myexp\Bundle\CmsBundle\Form\ContentModelType;

/**
 * ContentModel controller.
 *
 * @Route("/contentmodel")
 */
class ContentModelController extends Controller
{
    /**
     * Lists all ContentModel entities.
     *
     * @Route("/", name="contentmodel_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contentModels = $em->getRepository('MyexpCmsBundle:ContentModel')->findAll();

        return $this->render('contentmodel/index.html.twig', array(
            'contentModels' => $contentModels,
        ));
    }

    /**
     * Creates a new ContentModel entity.
     *
     * @Route("/new", name="contentmodel_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $contentModel = new ContentModel();
        $form = $this->createForm('Myexp\Bundle\CmsBundle\Form\ContentModelType', $contentModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contentModel);
            $em->flush();

            return $this->redirectToRoute('contentmodel_show', array('id' => $contentmodel->getId()));
        }

        return $this->render('contentmodel/new.html.twig', array(
            'contentModel' => $contentModel,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ContentModel entity.
     *
     * @Route("/{id}", name="contentmodel_show")
     * @Method("GET")
     */
    public function showAction(ContentModel $contentModel)
    {
        $deleteForm = $this->createDeleteForm($contentModel);

        return $this->render('contentmodel/show.html.twig', array(
            'contentModel' => $contentModel,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ContentModel entity.
     *
     * @Route("/{id}/edit", name="contentmodel_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ContentModel $contentModel)
    {
        $deleteForm = $this->createDeleteForm($contentModel);
        $editForm = $this->createForm('Myexp\Bundle\CmsBundle\Form\ContentModelType', $contentModel);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contentModel);
            $em->flush();

            return $this->redirectToRoute('contentmodel_edit', array('id' => $contentModel->getId()));
        }

        return $this->render('contentmodel/edit.html.twig', array(
            'contentModel' => $contentModel,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ContentModel entity.
     *
     * @Route("/{id}", name="contentmodel_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ContentModel $contentModel)
    {
        $form = $this->createDeleteForm($contentModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contentModel);
            $em->flush();
        }

        return $this->redirectToRoute('contentmodel_index');
    }

    /**
     * Creates a form to delete a ContentModel entity.
     *
     * @param ContentModel $contentModel The ContentModel entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ContentModel $contentModel)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contentmodel_delete', array('id' => $contentModel->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
