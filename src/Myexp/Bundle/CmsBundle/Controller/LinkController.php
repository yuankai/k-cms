<?php

namespace Myexp\Bundle\CmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\CmsBundle\Entity\Link;
use Myexp\Bundle\CmsBundle\Entity\LinkTranslation;
use Myexp\Bundle\CmsBundle\Form\LinkType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Link controller.
 *
 * @Route("/link")
 */
class LinkController extends Controller {

    /**
     * Lists all Link entities.
     *
     * @Route("/", name="link")
     * @Method("GET|DELETE")
     * @Template()
     */
    public function indexAction() {

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CmsBundle:Link')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays all Link entity.
     *
     * @Route("/all.html", name="link_all")
     * @Method("GET")
     * @Template("CmsBundle:Link:all.html.twig")
     */
    public function allAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CmsBundle:Link')->getAlllinks();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Link entity.
     *
     * @Route("/", name="link_create")
     * @Method("POST")
     * @Template("CmsBundle:Link:new.html.twig")
     */
    public function createAction(Request $request) {

        $entity = new Link();
        $form = $this->createForm(new LinkType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'common.success');

            return $this->redirect($this->generateUrl('link_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Change article status , active or delete.
     *
     * @Route("/status", name="link_status")
     * @Method("POST")
     */
    public function statusAction() {

        $ids = $this->getRequest()->get('ids', array());
        $url = $this->getRequest()->get('url');

        $paths = $this->getRequest()->get('paths', null);
        $orders = $this->getRequest()->get('orders', null);

        $em = $this->getDoctrine()->getManager();
        $ep = $this->getDoctrine()->getRepository('CmsBundle:Link');

        foreach ($ids as $id) {

            $link = $ep->find($id);
            $link->setPath($paths[$id]);
            $link->setSortOrder($orders[$id]);

            $em->persist($link);
        }

        $em->flush();

        $this->get('session')->getFlashBag()->add('notice', 'common.success');

        return $this->redirect($url);
    }

    /**
     * Displays a form to create a new Link entity.
     *
     * @Route("/new", name="link_new")
     * @Method("GET|POST")
     * @Template()
     */
    public function newAction() {

        $entity = new Link();
        $languages = $this->container->getParameter('languages');

        foreach (array_keys($languages) as $lang) {

            $translation = new LinkTranslation();
            $translation->setLang($lang);

            $entity->addTranslation($translation);
        }

        $form = $this->createForm(new LinkType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Link entity.
     *
     * @Route("/{id}", name="link_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CmsBundle:Link')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Link entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Link entity.
     *
     * @Route("/{id}/edit", name="link_edit")
     * @Method("GET|DELETE")
     * @Template()
     */
    public function editAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CmsBundle:Link')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Link entity.');
        }

        $editForm = $this->createForm(new LinkType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Link entity.
     *
     * @Route("/{id}", name="link_update")
     * @Method("PUT")
     * @Template("CmsBundle:Link:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CmsBundle:Link')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Link entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new LinkType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'common.success');

            return $this->redirect($this->generateUrl('link_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Link entity.
     *
     * @Route("/{id}", name="link_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {

        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CmsBundle:Link')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Link entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('notice', 'common.success');

        return $this->redirect($this->generateUrl('link'));
    }

    /**
     * Creates a form to delete a Link entity by id.
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
     * Displays a form to create a new Link entity.
     *
     * @Route("/link/apply", name="link_apply")
     * @Method("GET")
     * @Template()
     */
    public function applyAction() {

        $entity = new Link();
        $languages = $this->container->getParameter('languages');

        foreach (array_keys($languages) as $lang) {

            $translation = new LinkTranslation();
            $translation->setLang($lang);

            $entity->addTranslation($translation);
        }

        $form = $this->createForm(new LinkType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

}
