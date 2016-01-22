<?php

namespace Myexp\Bundle\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Node
 *
 * @ORM\Table(name="nodes")
 * @ORM\Entity(repositoryClass="Myexp\Bundle\CmsBundle\Repository\NodeRepository")
 */
class Node {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="sequenceId", type="integer")
     */
    private $sequenceId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;
    
     /**
     * @var Myexp\Bundle\CmsBundle\Entity\Website
     *
     * @ORM\ManyToOne(targetEntity="Website")
     * @ORM\JoinColumn(name="websiteId", referencedColumnName="id", onDelete="SET NULL")
     * @Assert\NotBlank()
     */
    private $website;
    
     /**
     * @var Myexp\Bundle\CmsBundle\Entity\MenuItem
     *
     * @ORM\ManyToOne(targetEntity="Node")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $parent;

    /**
     *
     * @ORM\OneToMany(targetEntity="Node", mappedBy="parent")
     */
    private $children;
}
