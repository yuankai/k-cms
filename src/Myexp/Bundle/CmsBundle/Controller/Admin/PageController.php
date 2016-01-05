<?php

namespace Myexp\Bundle\CmsBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\CmsBundle\Entity\Page;
use Myexp\Bundle\CmsBundle\Form\PageType;

/**
 * Page controller.
 *
 * @Route("/admin/page")
 */
class PageController extends AdminController {
    
    /**
     *
     * 主菜单
     * 
     * @var type 
     */
    protected $primaryMenu = 'admin_page';

    /**
     * Lists all Page entities.
     *
     * @Route("/", name="admin_page")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {

        $pageRepo = $this->getDoctrine()->getManager()->getRepository('MyexpCmsBundle:Page');

        $params = array();

        $pageTotal = $pageRepo->getPageCount($params);
        $sorts = array('a.createDate' => 'DESC', 'a.id' => 'DESC');
        $entities = $pageRepo->getPagesWithPagination(
                $params, $sorts, 0,10
        );

        return $this->display(array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Page entity.
     *
     * @Route("/", name="page_create")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("POST")
     * @Template("MyexpCmsBundle:Page:new.html.twig")
     */
    public function createAction(Request $request) {

        $entity = new Page();
        $form = $this->createForm(new PageType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'common.success');

            return $this->redirect($this->generateUrl('page_show', array('name' => $entity->getName())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Page entity.
     *
     * @Route("/new", name="admin_page_new")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {

        $entity = new Page();
        
        $form = $this->createForm(new PageType(), $entity);

        return $this->display(array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing Page entity.
     *
     * @Route("/{id}/edit", name="page_edit")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Page')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $editForm = $this->createForm(new PageType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Page entity.
     *
     * @Route("/{id}", name="page_update")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("PUT")
     * @Template("MyexpCmsBundle:Page:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Page')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Page entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PageType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'common.success');

            return $this->redirect($this->generateUrl('page_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Page entity.
     *
     * @Route("/{id}", name="page_delete")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {

        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyexpCmsBundle:Page')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Page entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('notice', 'common.success');

        return $this->redirect($this->generateUrl('page'));
    }

    /**
     * Creates a form to delete a Page entity by id.
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
     * Render current menu
     *
     * @Route("/upnew", name="page_upnew")
     * @Method("GET")
     * @Template()
     */
    public function upnewAction() {

        //置顶新闻查询笼位剩余数量
        $upnews = $this->getDoctrine()->getRepository('MyexpCmsBundle:Page')->findOneBy(array('name' => 'cage'));

        return array(
            'upnews' => $upnews
        );
    }

}
