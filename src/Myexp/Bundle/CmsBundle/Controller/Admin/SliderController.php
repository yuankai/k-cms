<?php

namespace Myexp\Bundle\CmsBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\CmsBundle\Entity\Slider;
use Myexp\Bundle\CmsBundle\Entity\SliderPhoto;
use Myexp\Bundle\CmsBundle\Form\SliderType;

/**
 * Slider controller.
 *
 * @Route("/admin/slider")
 */
class SliderController extends AdminController {
    
    
    /**
     *
     * 主菜单
     * 
     * @var type 
     */
    protected $primaryMenu = 'admin_slider';

    /**
     * 主实体
     * @var type 
     */
    protected $primaryEntity = 'Slider';
    
    /**
     * 主表单类型
     *
     * @var type 
     */
    protected $primaryFormType = SliderType::class;

    /**
     * Lists all Slider entities.
     *
     * @Route("/", name="admin_slider")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET|DELETE")
     * @Template()
     */
    public function indexAction() {
        return $this->index();
    }

    /**
     * Creates a new Slider entity.
     *
     * @Route("/", name="admin_slider_create")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("POST")
     * @Template("MyexpCmsBundle:Slider:new.html.twig")
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
     * @Route("/new", name="admin_slider_new")
     * @Security("has_role('ROLE_ADMIN')")
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
     * @Route("/{id}", name="admin_slider_show")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Slider')->find($id);

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
     * @Route("/{id}/edit", name="admin_slider_edit")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET|DELETE")
     * @Template()
     */
    public function editAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Slider')->find($id);

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
     * @Route("/{id}", name="admin_slider_update")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("PUT")
     * @Template("MyexpCmsBundle:Slider:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Slider')->find($id);

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
     * @Route("/{id}", name="admin_slider_delete")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {

        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyexpCmsBundle:Slider')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Slider entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('slider'));
    }
}
