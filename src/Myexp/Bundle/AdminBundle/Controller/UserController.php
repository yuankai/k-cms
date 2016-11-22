<?php

namespace Myexp\Bundle\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\AdminBundle\Form\ChangePasswordType;
use Myexp\Bundle\AdminBundle\Form\UserType;
use Myexp\Bundle\AdminBundle\Form\UserEditType;
use Myexp\Bundle\AdminBundle\Form\ChangePassword;
use Myexp\Bundle\AdminBundle\Entity\User;
use Myexp\Bundle\AdminBundle\Form\LoginType;

/**
 * User controller.
 *
 * @Route("/user")
 */
class UserController extends AdminController {

    /**
     *
     * @var type 
     */
    public $primaryEntity = "User";

    /**
     * 主表单类型
     *
     * @var type 
     */
    protected $primaryFormType = UserType::class;

    /**
     * Lists all User entities.
     *
     * @Route("/", name="admin_user")
     * @Security("has_role('ROLE_USER')")
     * @Method("GET|DELETE")
     * @Template()
     */
    public function indexAction() {
        $pagination = $this->getPagination();

        return $this->display(array(
                    'pagination' => $pagination
        ));
    }

    /**
     * Displays a form to change password.
     *
     * @Route("/password", name="admin_user_password")
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
     * @Route("/password_do", name="admin_user_password_do")
     * 
     * @Method("PUT")
     * @Template("MyexpAdminBundle:User:password.html.twig")
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
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("PUT")
     * @Template("MyexpAdminBundle:User:new.html.twig")
     */
    public function createAction(Request $request) {

        $entity = new User();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($entity);
            $password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
            $entity->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirectSucceed();
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
        $form = $this->createCreateForm($entity);

        return $this->display(array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}", name="admin_user_show")
     * 
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MyexpAdminBundle:User')->find($id);

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
        $entity = $em->getRepository('MyexpAdminBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm(new UserEditType(), $entity);
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
     * @Template("MyexpAdminBundle:User:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MyexpAdminBundle:User')->find($id);

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
     * @Route("/{id}", name="admin_user_delete")
     * 
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {

        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyexpAdminBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirectSucceed();
    }
    
    /**
     * Displays a form to login.
     *
     * @Template("MyexpAdminBundle:User:login.html.twig")
     */
    public function loginAction() {

        $helper = $this->get('security.authentication_utils');

        $form = $this->createForm(LoginType::class);

        return array(
            'last_username' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError(),
            'form' => $form->createView()
        );
    }

}
