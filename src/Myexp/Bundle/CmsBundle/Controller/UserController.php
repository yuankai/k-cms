<?php

namespace Myexp\Bundle\CmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Myexp\Bundle\CmsBundle\Form\ChangePasswordType;
use Myexp\Bundle\CmsBundle\Form\UserType;
use Myexp\Bundle\CmsBundle\Form\UserEditType;
use Myexp\Bundle\CmsBundle\Form\LoginType;
use Myexp\Bundle\CmsBundle\Form\ChangePassword;
use Myexp\Bundle\CmsBundle\Entity\User;

/**
 * User controller.
 *
 * @Route("/user")
 */
class UserController extends Controller {

    /**
     * Displays a form to login.
     *
     * @Route("/login", name="user_login")
     * @Method("GET")
     * @Template()
     */
    public function loginAction() {

        $helper = $this->get('security.authentication_utils');

        $form = $this->createForm(new LoginType());

        return array(
            'last_username' => $helper->getLastUsername(),
            'error' => $helper->getLastAuthenticationError(),
            'form' => $form->createView()
        );
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
     * @Template("CmsBundle:User:password.html.twig")
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
     * Finds and displays a User entity.
     *
     * @Route("/{id}", name="user_show")
     * 
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CmsBundle:User')->find($id);

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
     * @Route("/{id}/edit", name="user_edit")
     * 
     * @Method("GET|DELETE")
     * @Template()
     */
    public function editAction($id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CmsBundle:User')->find($id);

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
     * @Route("/{id}", name="user_update")
     * 
     * @Method("PUT")
     * @Template("CmsBundle:User:edit.html.twig")
     */
    public function updateAction(Request $request, $id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CmsBundle:User')->find($id);

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

}
