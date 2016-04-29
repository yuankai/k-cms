<?php

namespace Myexp\Bundle\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\AdminBundle\Entity\Node;
use Myexp\Bundle\AdminBundle\Form\NodeType;

/**
 * Node controller.
 *
 * @Route("/node")
 */
class NodeController extends AdminController {

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
                ->getRepository('MyexpAdminBundle:Node')
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
     * @Route("/", name="admin_node_create")
     * @Method("POST")
     * @Template("MyexpAdminBundle:Admin/Node:new.html.twig")
     */
    public function createAction(Request $request) {

        $entity = new Node();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->ajaxDisplay(array(
                        'id' => $entity->getId(),
                        'title' => $entity->getTitle()
            ));
        }

        $errors = $form->getErrors(true);

        return $this->ajaxDisplay(array('errors' => $errors));
    }

    /**
     * Displays a form to create a new Node entity.
     *
     * @Route("/new", name="admin_node_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Request $request) {

        $entity = new Node();
        $entity->setWebsite($this->currentWebsite);
        $entity->setIsActive(true);

        //上级节点
        $parentId = $request->get('parentId');
        if ($parentId) {
            $parent = $this
                    ->getDoctrine()
                    ->getRepository('MyexpAdminBundle:Node')
                    ->find($parentId)
            ;
            $entity->setParent($parent);
        }

        $form = $this->createCreateForm($entity, false);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * 
     * @Route("/get_models", name="admin_node_get_models")
     * @Method("GET")
     */
    public function getModelsAction(Request $request) {

        $nodeType = $request->get('nodeType', 'content_category');
        $isClassable = 'content_category' == $nodeType ? true : false;

        $contentModles = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('MyexpAdminBundle:ContentModel')
                ->findBy(array('isClassable' => $isClassable))
        ;

        $data = array();
        foreach ($contentModles as $contentModle) {
            $data[$contentModle->getId()] = $contentModle->getTitle();
        }

        return $this->ajaxDisplay(array('models' => $data));
    }

    /**
     * 
     * @Route("/get_nodes", name="admin_node_get_nodes")
     * @Method("GET")
     * @Template("MyexpAdminBundle:Node:nodes.html.twig")
     */
    public function getNodesAction(Request $request) {

        $nodeType = $request->get('nodeType');
        $nodeContentModel = $request->get('nodeContentModel');

        //内容类型
        $contentModle = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('MyexpAdminBundle:ContentModel')
                ->find($nodeContentModel)
        ;

        //最终数据
        $data = array(
            'nodeType' => $nodeType
        );

        //分类
        if ('content_category' == $nodeType) {

            $categories = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('MyexpAdminBundle:Category')
                    ->findBy(array(
                        'contentModel' => $contentModle,
                        'parent' => null
                    ))
            ;

            $data['categories'] = $categories;
        } elseif ('content' == $nodeType) {

            //内容
            $contents = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('MyexpAdminBundle:Content')
                    ->findBy(array(
                        'contentModel' => $contentModle
                    ))
            ;

            $data['contents'] = $contents;
        }

        return $data;
    }
    
    /**
     * 
     * @Route("/get_value", name="admin_node_get_value")
     * @Method("GET")
     */
    public function getValueAction(Request $request) {

        $nodeType = $request->get('nodeType');
        $nodeValue = $request->get('nodeValue');
        
        $em = $this
                ->getDoctrine()
                ->getManager()
        ;

        //分类
        if ('content_category' == $nodeType) {
            $entity = $em
                    ->getRepository('MyexpAdminBundle:Category')
                    ->find($nodeValue)
            ;
        } elseif ('content' == $nodeType) {
            //内容
            $entity = $em
                    ->getRepository('MyexpAdminBundle:Content')
                    ->find($nodeValue)
            ;
        }
        
        //最终数据
        $data = array(
            'title'=>$entity->getTitle(),
            'path'=>$entity->getDefaultPath()
        );
        
        return $this->ajaxDisplay($data);
    }

    /**
     * Finds and displays a Node entity.
     *
     * @Route("/{id}", name="admin_node_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpAdminBundle:Node')->find($id);

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
     * @Route("/{id}/edit", name="admin_node_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpAdminBundle:Node')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Node entity.');
        }

        $editForm = $this->createEditForm($entity, false);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Node entity.
     *
     * @Route("/{id}", name="admin_node_update")
     * @Method("PUT")
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpAdminBundle:Node')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Node entity.');
        }

        $editForm = $this->createEditForm($entity, false);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $em->flush();

            return $this->ajaxDisplay(array(
                        'id' => $entity->getId(),
                        'title' => $entity->getTitle()
            ));
        }

        $errors = $editForm->getErrors(true);

        return $this->ajaxDisplay(array('errors' => $errors));
    }

    /**
     * Deletes a Node entity.
     *
     * @Route("/{id}", name="admin_node_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyexpAdminBundle:Node')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Node entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('node'));
    }

}
