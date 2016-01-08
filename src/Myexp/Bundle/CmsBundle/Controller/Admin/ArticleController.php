<?php

namespace Myexp\Bundle\CmsBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\CmsBundle\Entity\Article;
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
    protected $primaryEntity = 'MyexpCmsBundle:Article';

    /**
     * Lists all Article entities.
     *
     * @Route("/", name="admin_article")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request) {
        return $this->index();
    }

    /**
     * Change article status , active or delete.
     *
     * @Route("/status", name="article_status")
     * @Method("POST")
     */
    public function statusAction() {

        $ids = $this->getRequest()->get('ids', array());
        $url = $this->getRequest()->get('url');

        $active = $this->getRequest()->get('active', null);
        $deny = $this->getRequest()->get('deny', null);
        $delete = $this->getRequest()->get('delete', null);

        $em = $this->getDoctrine()->getManager();
        $ep = $this->getDoctrine()->getRepository('MyexpCmsBundle:Article');

        foreach ($ids as $id) {
            $article = $ep->find($id);

            if ($active) {
                $article->setIsActive(true);
                $em->persist($article);
            } elseif ($deny) {
                $article->setIsActive(false);
                $em->persist($article);
            } elseif ($delete) {
                $em->remove($article);
            }
            $em->flush();
        }
        $this->get('session')->getFlashBag()->add('notice', 'common.success');

        return $this->redirect($url);
    }

    /**
     * Creates a new Article entity.
     *
     * @Route("/", name="admin_article_create")
     * @Method("POST")
     * @Template("MyexpCmsBundle:Article:new.html.twig")
     */
    public function createAction(Request $request) {

        $entity = new Article();
        $form = $this->createForm(new ArticleType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'common.success');

            return $this->redirect($this->generateUrl('article_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Article entity.
     *
     * @Route("/new", name="admin_article_new")
     * @Method("POST|GET")
     * @Template()
     */
    public function newAction() {

        $entity = new Article();

        $entity->setIsActive(true);
        $entity->setPublishTime(new \DateTime());
        $form = $this->createForm(ArticleType::class, $entity);

        return $this->display(array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Article entity.
     *
     * @Route("/view-{id}.html", name="article_show", requirements={"id"="\d+"})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MyexpCmsBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        //分类
        $category = $entity->getCategory();
        $topCategory = $category->getTopCategory();

        return array(
            'entity' => $entity,
            'category' => $category,
            'topCategory' => $topCategory
        );
    }

    /**
     * Finds and display article entities by category.
     *
     * @Route("/{name}.html", name="article_list")
     * @Method("GET")
     * @Template()
     */
    public function listAction($name) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Category')->findOneBy(array(
            'name' => $name
        ));

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        //当前列表的顶级分类
        $topCategory = $entity->getTopCategory();

        //分页处理
        $articleRepo = $em->getRepository('MyexpCmsBundle:Article');
        $params = array(
            'category' => $entity,
            'isActive' => true
        );
        $articleTotal = $articleRepo->getArticleCount($params);
        $paginator = new Paginator($articleTotal);
        $paginator->setShowLimit(false);

        $sorts = array('a.publishTime' => 'DESC');
        $entities = $articleRepo->getArticlesWithPagination(
                $params, $sorts, $paginator->getOffset(), $paginator->getLimit()
        );

        return array(
            'entities' => $entities,
            'paginator' => $paginator,
            'topCategory' => $topCategory,
            'category' => $entity
        );
    }

    /**
     * Displays a form to edit an existing Article entity.
     *
     * @Route("/{id}/edit", name="article_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        $editForm = $this->createForm(new ArticleType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Article entity.
     *
     * @Route("/{id}", name="article_update")
     * @Method("PUT")
     * @Template("MyexpCmsBundle:Article:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyexpCmsBundle:Article')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Article entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ArticleType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {

            //更新时间
            $entity->setUpdateTime(new \Datetime());

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'common.success');

            return $this->redirect($this->generateUrl('article_edit', array('id' => $id)));
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
     * @Route("/{id}", name="article_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {

        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyexpCmsBundle:Article')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Article entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('notice', 'common.success');

        return $this->redirect($this->generateUrl('article'));
    }

    /**
     * Creates a form to delete a Article entity by id.
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
     * Render notice block
     *
     * @Route("/notice", name="article_notice")
     * @Method("GET")
     * @Template("MyexpCmsBundle:Chips:notice.html.twig")
     */
    public function noticeAction() {

        $em = $this->getDoctrine()->getRepository('MyexpCmsBundle:Article');
        $notices = $em->getTitles(3, 6);

        return array(
            'notices' => $notices
        );
    }

}
