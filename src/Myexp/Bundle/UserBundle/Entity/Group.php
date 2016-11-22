<?php

namespace Myexp\Bundle\UserBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Group
 *
 * @ORM\Entity
 * @ORM\Table(name="groups")
 * 
 * @author Kevin
 */
class Group extends BaseGroup {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

}
