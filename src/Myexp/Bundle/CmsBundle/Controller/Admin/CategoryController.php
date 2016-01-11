<?php

namespace Myexp\Bundle\CmsBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
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

        $websiteId = $request->get('websiteId', $websites[0]->getId());
        $contentModelId = $request->get('contentModelId', $contentModels[0]->getId());

        return $this->display(array(
                    'websites' => $websites,
                    'contentModels' => $contentModels,
                    'websiteId' => $websiteId,
                    'contentModelId' => $contentModelId
        ));
    }

    /**
     * Get menus recursively
     * 
     * @access private
     */
    private function getCategoryByRecursive(&$result, $parent = null, $depth = 0) {

        $em = $this->getDoctrine()->getManager();

        if ($parent instanceof Category) {
            $prefix = '';
            for ($i = 1; $i < $depth; $i++) {
                $prefix .= '|------';
            }
            $parent->getTrans()->setTitle($prefix . ' ' . $parent->getTrans()->getTitle());
            $result[] = $parent;
        }

        $entities = $em->getRepository('MyexpCmsBundle:Category')->getChildren($parent);

        foreach ($entities as $menu) {
            $this->getCategoryByRecursive($result, $menu, $depth + 1);
        }
    }

    /**
     * Creates a new Category entity.
     *
     * @Route("/", name="category_create")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("POST")
     * @Template("MyexpCmsBundle:Category:new.html.twig")
     */
    public function createAction(Request $request) {

        $entity = new Category();
        $form = $this->createForm(new CategoryType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'common.success');

            return $this->redirect($this->generateUrl('category'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Category entity.
     *
     * @Route("/new", name="category_new")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function newAction() {

        $entity = new Category();
        $languages = $this->container->getParameter('languages');

        foreach (array_keys($languages) as $lang) {

            $translation = new CategoryTranslation();
            $translation->setLang($lang);

            $entity->addTranslation($translation);
        }

        $form = $this->createForm(new CategoryType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Category entity.
     *
     * @Route("/{id}", name="category_show")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{id}/edit", name="category_edit")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET|DELETE")
     * @Template()
     */
    public function editAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm = $this->createForm(new CategoryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Category entity.
     *
     * @Route("/{id}", name="category_update")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("PUT")
     * @Template("MyexpCmsBundle:Category:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CategoryType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'common.success');

            return $this->redirect($this->generateUrl('category_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/{id}", name="category_delete")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
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
