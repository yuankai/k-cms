<?php

namespace Myexp\Bundle\CmsBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\CmsBundle\Entity\Node;
use Myexp\Bundle\CmsBundle\Form\NodeType;

/**
 * Node controller.
 *
 * @Route("/admin/node")
 */
class NodeController extends AdminController {

    /**
     *
     * 主菜单
     * 
     * @var type 
     */
    protected $primaryMenu = 'admin_node';

    /**
     * 主实体
     * @var type 
     */
    protected $primaryEntity = 'Node';

    /**
     * 主表单类型
     *
     * @var type 
     */
    protected $primaryFormType = NodeType::class;

    /**
     * Lists all Node entities.
     *
     * @Route("/", name="admin_node")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {

        $em = $this->getDoctrine()->getManager();
        $website = $this->currentWebsite;

        //top node items
        $topNodes = $em
                ->getRepository('MyexpCmsBundle:Node')
                ->findBy(
                array(
                    'website' => $website,
                    'parent' => null
                ))
        ;

        return $this->display(array(
                    'topNodes' => $topNodes
        ));
    }

    /**
     * Creates a new Node entity.
     *
     * @Route("/", name="node_create")
     * @Method("POST")
     * @Template("MyexpCmsBundle:Node:new.html.twig")
     */
    public function createAction(Request $request) {
        $entity = new Node();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('node_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Node entity.
     *
     * @Route("/new", name="node_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {
        $entity = new Node();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Node entity.
     *
     * @Route("/{id}", name="node_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Node')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Node entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Node entity.
     *
     * @Route("/{id}/edit", name="node_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Node')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Node entity.');
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
     * Edits an existing Node entity.
     *
     * @Route("/{id}", name="node_update")
     * @Method("PUT")
     * @Template("MyexpCmsBundle:Node:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Node')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Node entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('node_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Node entity.
     *
     * @Route("/{id}", name="node_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyexpCmsBundle:Node')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Node entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('node'));
    }

}
