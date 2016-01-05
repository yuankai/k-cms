<?php

namespace Myexp\Bundle\CmsBundle\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;

class LoginListener {

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
    public function __construct(Doctrine $doctrine) {
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
