<?php

namespace Myexp\Bundle\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Myexp\Bundle\AdminBundle\Entity\Category;
use Myexp\Bundle\AdminBundle\Form\CategoryType;

/**
 * Category controller.
 *
 * @Route("/category")
 */
class CategoryController extends AdminController {

    /**
     * 主实体
     * @var type 
     */
    protected $primaryEntity = 'Category';

    /**
     * 主表单类型
     *
     * @var type 
     */
    protected $primaryFormType = CategoryType::class;

    /**
     * Lists all Category entities.
     *
     * @Route("/", name="admin_category")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request) {

        $em = $this->getDoctrine()->getManager();

        $contentModels = $em
                ->getRepository('MyexpAdminBundle:ContentModel')
                ->getClassableModels()
        ;

        $contentModelId = $request->get('contentModelId');
        if (!$contentModelId) {
            $contentModelId = $contentModels[0]->getId();
        }

        $topCategories = $em
                ->getRepository('MyexpAdminBundle:Category')
                ->findBy(
                array(
                    'website' => $this->currentWebsite,
                    'contentModel' => $contentModelId,
                    'parent' => null
                ))
        ;

        return $this->display(array(
                    'contentModels' => $contentModels,
                    'contentModelId' => $contentModelId,
                    'topCategories' => $topCategories
        ));
    }

    /**
     * Creates a new Category entity.
     *
     * @Route("/create", name="admin_category_create")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("POST")
     */
    public function createAction(Request $request) {

        $entity = new Category();

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
     * Displays a form to create a new Category entity.
     *
     * @Route("/new", name="admin_menu_category")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function newAction(Request $request) {

        $entity = new Category();
        $entity->setIsActive(true);

        $contentModelId = $request->get('contentModelId');
        $contentModel = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('MyexpAdminBundle:ContentModel')
                ->find($contentModelId);

        $entity->setWebsite($this->currentWebsite);
        $entity->setContentModel($contentModel);

        //上级节点
        $parentId = $request->get('parentId');
        if ($parentId) {
            $parent = $this
                    ->getDoctrine()
                    ->getRepository('MyexpAdminBundle:Category')
                    ->find($parentId)
            ;
            $entity->setParent($parent);
        }

        $form = $this->createCreateForm($entity, false);

        return $this->display(array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{id}/edit", name="admin_category_edit")
     * @Method({"GET"})
     * @Template()
     */
    public function editAction(Request $request, Category $category) {

        $editForm = $this->createEditForm($category, false);
        $editForm->handleRequest($request);

        return $this->display(array(
                    'edit_form' => $editForm->createView()
        ));
    }

    /**
     * Edits an existing Menu entity.
     *
     * @Route("/{id}", name="admin_category_update")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("PUT")
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpAdminBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $em->persist($entity);
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
     * Rename an existing Category entity.
     *
     * @Route("/move", name="admin_category_move")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("POST")
     */
    public function moveAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');

        $entity = $em->getRepository('MyexpAdminBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        //上级分类
        $parentId = $request->get('parentId');
        if($parentId){
            $parent = $em
                    ->getRepository('MyexpAdminBundle:Category')
                    ->find($parentId);
            $entity->setParent($parent);
        } else {
            $entity->setParent(null);
        }
        
        //重新排序
        if($parentId){
            $children = $entity->getParent()->getChildren();
        } else {
            $children = $em
                    ->getRepository('MyexpAdminBundle:Category')
                    ->findBy(array('parent'=>null), array('sequenceId'=>'ASC'));
        }
        
        $em->persist($entity);
        $em->flush();

        return $this->ajaxDisplay();
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/delete", name="admin_category_delete")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("POST")
     */
    public function deleteAction(Request $request) {

        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MyexpAdminBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->ajaxDisplay();
    }
}
