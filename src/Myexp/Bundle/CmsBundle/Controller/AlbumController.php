<?php

namespace Myexp\Bundle\CmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\CmsBundle\Entity\Album;
use Myexp\Bundle\CmsBundle\Entity\AlbumTranslation;
use Myexp\Bundle\CmsBundle\Form\AlbumType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Album controller.
 *
 * @Route("/album")
 */
class AlbumController extends Controller {

    /**
     * Lists all Album entities.
     *
     * @Route("/", name="album")
     * @Secure(roles="ROLE_ADMIN_USER")
     * @Method("GET|DELETE")
     * @Template()
     */
    public function indexAction() {

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CmsBundle:Album')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Album entity.
     *
     * @Route("/", name="album_create")
     * @Secure(roles="ROLE_ADMIN_USER")
     * @Method("POST")
     * @Template("CmsBundle:Album:new.html.twig")
     */
    public function createAction(Request $request) {

        $entity = new Album();
        $form = $this->createForm(new AlbumType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'common.success');

            return $this->redirect($this->generateUrl('album_show', array('name' => $entity->getName())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Album entity.
     *
     * @Route("/new", name="album_new")
     * @Secure(roles="ROLE_ADMIN_USER")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {

        $entity = new Album();
        $languages = $this->container->getParameter('languages');

        foreach (array_keys($languages) as $lang) {

            $translation = new AlbumTranslation();
            $translation->setLang($lang);

            $entity->addTranslation($translation);
        }

        $form = $this->createForm(new AlbumType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Album entity.
     *
     * @Route("/{name}.html", name="album_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($name) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CmsBundle:Album')->findOneBy(array(
            'name' => $name
        ));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

        return array(
            'entity' => $entity
        );
    }

    /**
     * Displays a form to edit an existing Album entity.
     *
     * @Route("/{id}/edit", name="album_edit")
     * @Secure(roles="ROLE_ADMIN_USER")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CmsBundle:Album')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

        $editForm = $this->createForm(new AlbumType(), $entity);
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
     * @Route("/{id}", name="album_update")
     * @Secure(roles="ROLE_ADMIN_USER")
     * @Method("PUT")
     * @Template("CmsBundle:Album:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CmsBundle:Album')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new AlbumType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'common.success');

            return $this->redirect($this->generateUrl('album_edit', array('id' => $id)));
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
     * @Route("/{id}", name="album_delete")
     * @Secure(roles="ROLE_ADMIN_USER")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CmsBundle:Album')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Album entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('album'));
    }

    /**
     * Creates a form to delete a Album entity by id.
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

}
