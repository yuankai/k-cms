<?php

namespace Myexp\Bundle\CmsBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Myexp\Bundle\CmsBundle\Form\ChangePasswordType;
use Myexp\Bundle\CmsBundle\Form\UserType;
use Myexp\Bundle\CmsBundle\Form\UserEditType;
use Myexp\Bundle\CmsBundle\Form\LoginType;
use Myexp\Bundle\CmsBundle\Form\ChangePassword;
use Myexp\Bundle\CmsBundle\Entity\User;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * User controller.
 *
 * @Route("/admin/user")
 */
class UserController extends AdminController {
    
    /**
     * @var type 
     */
    public $primaryMenu = "admin_user";

    /**
     * Lists all User entities.
     *
     * @Route("/", name="admin_user")
     * @Security("has_role('ROLE_USER')")
     * @Method("GET|DELETE")
     * @Template()
     */
    public function indexAction() {

        $user_repo = $this->getDoctrine()->getManager()->getRepository('MyexpCmsBundle:User');

        $user_total = $user_repo->getUserCount();
        //$paginator = new Paginator($user_total);

        $entities = $user_repo->getUsersWithPagination(
                array('id' => 'DESC'), 0, 5
        );

        return $this->display(array(
            'entities' => $entities
        ));
    }

    /**
     * Displays a form to change password.
     *
     * @Route("/password", name="user_password")
     * 
     * @Method("GET")
     * @Template()
     */
    public function passwordAction() {

        $changePassword = new ChangePassword();
        $form = $this->createForm(new ChangePasswordType, $changePassword);

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * Change password.
     *
     * @Route("/password_do", name="user_password_do")
     * 
     * @Method("PUT")
     * @Template("MyexpCmsBundle:User:password.html.twig")
     */
    public function passwordDoAction() {

        $request = $this->getRequest();
        $changePassword = new ChangePassword();
        $form = $this->createForm(new ChangePasswordType, $changePassword);

        $form->bind($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $changePassword = $form->getData();

            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($changePassword->getNewPassword(), $user->getSalt());
            $user->setPassword($password);

            $em->persist($user);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'common.success');

            return $this->redirect($this->generateUrl('user_password'));
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * Creates a new User entity.
     *
     * @Route("/create", name="admin_user_create")
     * 
     * @Method("PUT")
     * @Template("MyexpCmsBundle:User:new.html.twig")
     */
    public function createAction(Request $request) {

        $entity = new User();
        $form = $this->createForm(new UserType(), $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($entity);
            $password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
            $entity->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'common.success');

            return $this->redirect($this->generateUrl('user_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new User entity.
     *
     * @Route("/new", name="admin_user_new")
     * 
     * @Method("GET")
     * @Template()
     */
    public function newAction() {

        $entity = new User();
        $form = $this->createForm(new UserType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}", name="user_show")
     * 
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MyexpCmsBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="admin_user_edit")
     * 
     * @Method("GET|DELETE")
     * @Template()
     */
    public function editAction($id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MyexpCmsBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createForm(new UserEditType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}", name="admin_user_update")
     * 
     * @Method("PUT")
     * @Template("MyexpCmsBundle:User:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MyexpCmsBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new UserEditType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'common.success');

            return $this->redirect($this->generateUrl('user'));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a User entity.
     *
     * @Route("/{id}", name="user_delete")
     * 
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {

        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyexpCmsBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('notice', 'common.success');

        return $this->redirect($this->generateUrl('user'));
    }

    /**
     * Creates a form to delete a User entity by id.
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
    

}
