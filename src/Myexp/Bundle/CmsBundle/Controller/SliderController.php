<?php

namespace Myexp\Bundle\CmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\CmsBundle\Entity\Slider;
use Myexp\Bundle\CmsBundle\Entity\SliderPhoto;
use Myexp\Bundle\CmsBundle\Form\SliderType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Slider controller.
 *
 * @Route("/slider")
 */
class SliderController extends Controller {

    /**
     * Lists all Slider entities.
     *
     * @Route("/", name="slider")
     * @Secure(roles="ROLE_ADMIN_USER")
     * @Method("GET|DELETE")
     * @Template()
     */
    public function indexAction() {

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SmtCmsBundle:Slider')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Slider entity.
     *
     * @Route("/", name="slider_create")
     * @Secure(roles="ROLE_ADMIN_USER")
     * @Method("POST")
     * @Template("SmtCmsBundle:Slider:new.html.twig")
     */
    public function createAction(Request $request) {

        $entity = new Slider();
        $form = $this->createForm(new SliderType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('slider_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Slider entity.
     *
     * @Route("/new", name="slider_new")
     * @Secure(roles="ROLE_ADMIN_USER")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {

        $entity = new Slider();
        $entity->addSliderPhoto(new SliderPhoto());
        $form = $this->createForm(new SliderType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Slider entity.
     *
     * @Route("/{id}", name="slider_show")
     * @Secure(roles="ROLE_ADMIN_USER")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SmtCmsBundle:Slider')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slider entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Slider entity.
     *
     * @Route("/{id}/edit", name="slider_edit")
     * @Secure(roles="ROLE_ADMIN_USER")
     * @Method("GET|DELETE")
     * @Template()
     */
    public function editAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SmtCmsBundle:Slider')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slider entity.');
        }

        $editForm = $this->createForm(new SliderType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Slider entity.
     *
     * @Route("/{id}", name="slider_update")
     * @Secure(roles="ROLE_ADMIN_USER")
     * @Method("PUT")
     * @Template("SmtCmsBundle:Slider:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SmtCmsBundle:Slider')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Slider entity.');
        }

        //获得原始的幻灯图片
        $originalSliderPhotos = array();
        foreach ($entity->getSliderPhotos() as $sliderPhoto) {
            $originalSliderPhotos[] = $sliderPhoto;
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SliderType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {

            foreach ($entity->getSliderPhotos() as $sliderPhoto) {
                foreach ($originalSliderPhotos as $key => $toDelete) {
                    if ($toDelete->getId() === $sliderPhoto->getId()) {
                        unset($originalSliderPhotos[$key]);
                    }
                }
            }

            foreach ($originalSliderPhotos as $sliderPhoto) {
                $em->remove($sliderPhoto);
            }

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'common.success');

            return $this->redirect($this->generateUrl('slider_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Slider entity.
     *
     * @Route("/{id}", name="slider_delete")
     * @Secure(roles="ROLE_ADMIN_USER")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {

        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SmtCmsBundle:Slider')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Slider entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('slider'));
    }

    /**
     * Render a Slider entity.
     *
     * @Route("/render/{name}", name="slider_render")
     * @Method("GET")
     * @Template()
     */
    public function renderAction($name) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SmtCmsBundle:Slider')->findOneBy(array(
            'name' => $name
        ));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        return array(
            'slider' => $entity
        );
    }

    /**
     * Creates a form to delete a Slider entity by id.
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
