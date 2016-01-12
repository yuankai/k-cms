<?php

namespace Myexp\Bundle\CmsBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\CmsBundle\Entity\Category;
use Myexp\Bundle\CmsBundle\Form\CategoryType;

/**
 * Category controller.
 *
 * @Route("/admin/category")
 */
class CategoryController extends AdminController {

    /**
     *
     * 主菜单
     * 
     * @var type 
     */
    protected $primaryMenu = 'admin_category';

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

        $websites = $em->getRepository('MyexpCmsBundle:Website')->findAll();
        $contentModels = $em->getRepository('MyexpCmsBundle:ContentModel')->findAll();

        $websiteId = $contentModelId = 0;

        if (!empty($websites)) {
            $websiteId = $request->get('websiteId', $websites[0]->getId());
        }

        if (!empty($contentModels)) {
            $contentModelId = $request->get('contentModelId', $contentModels[0]->getId());
        }

        $topCategories = $em->getRepository('MyexpCmsBundle:Category')->findBy(array(
            'contentModel' => $contentModelId,
            'parent' => null
        ));

        return $this->display(array(
                    'websites' => $websites,
                    'contentModels' => $contentModels,
                    'websiteId' => $websiteId,
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

        $form = $this->createForm($this->primaryFormType, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->ajaxDisplay(array('id' => $entity->getId()));
        }

        $errors = $form->getErrors(true);

        return $this->ajaxDisplay(array('errors' => $errors));
    }

    /**
     * Rename an existing Category entity.
     *
     * @Route("/rename", name="admin_category_rename")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("POST")
     */
    public function renameAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');

        $entity = $em->getRepository('MyexpCmsBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $title = $request->get('title');
        $entity->setTitle($title);

        $em->persist($entity);
        $em->flush();

        return $this->ajaxDisplay();
    }

    /**
     * Edits an existing Category entity.
     *
     * @Route("/update", name="admin_category_update")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("POST")
     */
    public function updateAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');

        $entity = $em->getRepository('MyexpCmsBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm = $this->createForm($this->primaryFormType, $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            $em->persist($entity);
            $em->flush();

            return $this->ajaxDisplay();
        }

        $errors = $editForm->getErrors(true);

        return $this->ajaxDisplay(array('errors' => $errors));
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
        $entity = $em->getRepository('MyexpCmsBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->ajaxDisplay();
    }

    /**
     * Copy and paste a Category entity.
     *
     * @Route("/paste", name="admin_category_paste")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("POST")
     */
    public function pasteAction(Request $request, $id) {

        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyexpCmsBundle:Category')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('category'));
    }

}
