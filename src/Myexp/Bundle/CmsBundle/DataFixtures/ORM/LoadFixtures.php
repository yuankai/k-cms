<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Myexp\Bundle\CmsBundle\DataFixtures\ORM;

use Myexp\Bundle\CmsBundle\Entity\User;
use Myexp\Bundle\CmsBundle\Entity\Role;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines the sample data to load in the database when running the unit and
 * functional tests. Execute this command to load the data:
 *
 *   $ php app/console doctrine:fixtures:load
 *
 * See http://symfony.com/doc/current/bundles/DoctrineFixturesBundle/index.html
 *
 */
class LoadFixtures implements FixtureInterface, ContainerAwareInterface {

    /** @var ContainerInterface */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager) {
        $this->loadRoles($manager);
        $this->loadUsers($manager);
    }

    /**
     * 加载用户
     * @param ObjectManager $manager
     */
    private function loadUsers(ObjectManager $manager) {
        $passwordEncoder = $this->container->get('security.password_encoder');

        $adminUser = new User();
        $adminUser->setUsername('admin');
        $adminUser->setEmail('admin@mydomain.com');
        $encodedPassword = $passwordEncoder->encodePassword($adminUser, '123456');
        $adminUser->setPassword($encodedPassword);
        
        $userRole = $manager->getRepository('MyexpCmsBundle:Role')
                ->findOneBy(array('role' => 'ROLE_USER'));
        $adminRole = $manager->getRepository('MyexpCmsBundle:Role')
                ->findOneBy(array('role' => 'ROLE_ADMIN'));

        $adminUser->addRole($userRole);
        $adminUser->addRole($adminRole);
        
        $manager->persist($adminUser);

        $manager->flush();
    }

    /**
     * 加载角色
     * 
     * @param ObjectManager $manager
     */
    private function loadRoles(ObjectManager $manager) {

        $userRole = new Role();
        $userRole->setName("普通用户");
        $userRole->setRole("ROLE_USER");
        $manager->persist($userRole);

        $adminRole = new Role();
        $adminRole->setName("管理员用户");
        $adminRole->setRole("ROLE_ADMIN");
        $manager->persist($adminRole);

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

}
