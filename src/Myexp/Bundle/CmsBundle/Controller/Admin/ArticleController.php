<?php

namespace Myexp\Bundle\CmsBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\CmsBundle\Entity\Article;
use Myexp\Bundle\CmsBundle\Entity\Content;
use Myexp\Bundle\CmsBundle\Form\ArticleType;

/**
 * Article controller.
 *
 * @Route("/admin/article")
 */
class ArticleController extends AdminController {

    /**
     *
     * 主菜单
     * 
     * @var type 
     */
    protected $primaryMenu = 'admin_article';

    /**
     * 主实体
     * @var type 
     */
    protected $primaryEntity = 'Article';

    /**
     * 主表单类型
     *
     * @var type 
     */
    protected $primaryFormType = ArticleType::class;

    /**
     * Lists all Article entities.
     *
     * @Route("/", name="admin_article")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        return $this->index();
    }

    /**
     * Creates a new Article entity.
     *
     * @Route("/", name="admin_article_create")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("POST")
     * @Template("MyexpCmsBundle:Admin/Article:new.html.twig")
     */
    public function createAction(Request $request) {

        $entity = new Article();
        
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $this->saveContentInstance($entity->getContent());
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirectSucceed();
        }

        return $this->display(array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Article entity.
     *
     * @Route("/new", name="admin_article_new")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("POST|GET")
     * @Template()
     */
    public function newAction() {

        $entity = new Article();
        $content = $this->newContentInstance('article');
        
        $entity->setPublishTime(new \DateTime());
        $entity->setContent($content);
        
        $form = $this->createCreateForm($entity);

        return $this->display(array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Article entity.
     *
     * @Route("/{id}/edit", name="admin_article_edit")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->display(array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Article entity.
     *
     * @Route("/{id}", name="admin_article_update")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("PUT")
     * @Template("MyexpCmsBundle:Admin/Article:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            //更新内容信息
            $this->saveContentInstance($entity->getContent());

            //保存文章
            $em->persist($entity);
            $em->flush();

            return $this->redirectSucceed();
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Article entity.
     *
     * @Route("/{id}", name="admin_article_delete")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyexpCmsBundle:Article')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Article entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirectSucceed();
    }

}
