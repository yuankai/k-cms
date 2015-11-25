<?php

namespace Myexp\Bundle\CmsBundle\Listener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;

class LoginListener {

    /**
     * @var \Symfony\Component\Security\Core\SecurityContext 
     */
    private $securityContext;

    /**
     * @var \Doctrine\ORM\EntityManager 
     */
    private $em;

    /**
     * Constructor
     *
     * @param SecurityContext $securityContext
     * @param Doctrine $doctrine
     */
    public function __construct(SecurityContext $securityContext, Doctrine $doctrine) {
        $this->securityContext = $securityContext;
        $this->em = $doctrine->getManager();
    }

    /**
     * Do the magic.
     *
     * @param InteractiveLoginEvent $event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event) {

        $user = $event->getAuthenticationToken()->getUser();

        if ($user) {
            $user->setLastLogin(new \DateTime());
            $user->setLogins($user->getLogins() + 1);
            $this->em->flush();
        }
    }

}
