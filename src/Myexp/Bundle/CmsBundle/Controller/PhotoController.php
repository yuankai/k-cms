<?php

namespace Myexp\Bundle\CmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\CmsBundle\Entity\Photo;
use Myexp\Bundle\CmsBundle\Entity\PhotoTranslation;
use Myexp\Bundle\CmsBundle\Form\PhotoType;
use Myexp\Bundle\CmsBundle\Helper\Paginator;

/**
 * Photo controller.
 *
 * @Route("/photo")
 */
class PhotoController extends Controller {

    /**
     * Lists all Photo entities.
     *
     * @Route("/", name="photo")
     * @Method("GET|DELETE")
     * @Template()
     */
    public function indexAction() {

        $photoRepo = $this->getDoctrine()->getManager()->getRepository('MyexpCmsBundle:Photo');

        $params = array();

        $photoTotal = $photoRepo->getPhotoCount($params);
        $paginator = new Paginator($photoTotal);

        $sorts = array('a.createDate' => 'DESC', 'p.id' => 'DESC');
        $entities = $photoRepo->getPhotosWithPagination(
                $params, $sorts, $paginator->getOffset(), $paginator->getLimit()
        );

        return array(
            'entities' => $entities,
            'paginator' => $paginator
        );
    }
    


    /**
     * Change photo status , active or delete.
     *
     * @Route("/status", name="photo_status")
     * @Method("POST")
     */
    public function statusAction() {

        $ids = $this->getRequest()->get('ids', array());
        $url = $this->getRequest()->get('url');

        $active = $this->getRequest()->get('active', null);
        $deny = $this->getRequest()->get('deny', null);
        $delete = $this->getRequest()->get('delete', null);

        $em = $this->getDoctrine()->getManager();
        $ep = $this->getDoctrine()->getRepository('MyexpCmsBundle:Photo');

        foreach ($ids as $id) {
            $photo = $ep->find($id);

            if ($active || $deny) {
                $photo->setIsActive($active ? true : false);
                $em->persist($photo);
            } elseif ($delete) {
                $em->remove($photo);
                $em->flush();
            }
        }

        $this->get('session')->getFlashBag()->add('notice', 'common.success');

        return $this->redirect($url);
    }

    /**
     * Creates a new Photo entity.
     *
     * @Route("/", name="photo_create")
     * @Method("POST")
     * @Template("MyexpCmsBundle:Photo:new.html.twig")
     */
    public function createAction(Request $request) {

        $entity = new Photo();
        $form = $this->createForm(new PhotoType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'common.success');

            return $this->redirect($this->generateUrl('photo_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Photo entity.
     *
     * @Route("/new", name="photo_new")
     * @Method("GET|POST")
     * @Template()
     */
    public function newAction() {

        $entity = new Photo();
        $languages = $this->container->getParameter('languages');

        foreach (array_keys($languages) as $lang) {

            $translation = new PhotoTranslation();
            $translation->setLang($lang);

            $entity->addTranslation($translation);
        }

        $entity->setIsActive(true);
        $form = $this->createForm(new PhotoType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Photo entity.
     *
     * @Route("/view-{id}.html", name="photo_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MyexpCmsBundle:Photo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Photo entity.');
        }

        //获得所有相册
        $album = $entity->getAlbum();
        return array(
            'current' => $album,
            'entity' => $entity
        );
    }

    /**
     * Finds and display photo entities by album.
     *
     * @Route("/$name/list", name="photo_list")
     * @Method("GET")
     * @Template()
     */
    public function listAction($name) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Album')->findOneBy(array(
            'name' => $name
        ));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Album entity.');
        }

        //处理该相册下的图片
        $photoRepo = $this->getDoctrine()->getManager()->getRepository('MyexpCmsBundle:Photo');
        $params = array(
            'album' => $entity,
            'isActive' => true
        );

        $photoTotal = $photoRepo->getPhotoCount($params);
        $paginator = new Paginator($photoTotal);
        $paginator->setShowLimit(false);

        $sorts = array('p.createTime' => 'DESC', 'p.id' => 'DESC');
        $entities = $photoRepo->getPhotosWithPagination(
                $params, $sorts, $paginator->getOffset(), $paginator->getLimit()
        );

        return array(
            'current' => $entity,
            'entities' => $entities,
            'paginator' => $paginator
        );
    }

    /**
     * Displays a form to edit an existing Photo entity.
     *
     * @Route("/{id}/edit", name="photo_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Photo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Photo entity.');
        }

        $editForm = $this->createForm(new PhotoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Photo entity.
     *
     * @Route("/{id}", name="photo_update")
     * @Method("PUT")
     * @Template("MyexpCmsBundle:Photo:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Photo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Photo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PhotoType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {

            //更新时间
            $entity->setUpdateTime(new \Datetime());

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'common.success');

            return $this->redirect($this->generateUrl('photo_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Photo entity.
     *
     * @Route("/{id}", name="photo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {

        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyexpCmsBundle:Photo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Photo entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('notice', 'common.success');

        return $this->redirect($this->generateUrl('photo'));
    }

    /**
     * Creates a form to delete a Photo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {

        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm();
    }
    
    /**
     * index slider photo.
     *
     * @Route("/slider", name="photo_slider")
     * @Method("GET")
     * @Template()
     */
    public function sliderAction($id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MyexpCmsBundle:Photo')->getSlider($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Photo entity.');
        }

        return array(
            'entities' => $entity
        );
    }

}
