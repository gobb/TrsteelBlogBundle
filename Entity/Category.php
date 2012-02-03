<?php

namespace Trsteel\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trsteel\BlogBundle\Entity\Category
 *
 * @ORM\Table(name="trsteel_blog_category")
 * @ORM\Entity
 * @ORM\HasLifeCycleCallBacks
 * @ORM\Entity(repositoryClass="Trsteel\BlogBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Please enter a category.")
     */
    private $title;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @Assert\DateTime()
     */
    private $created_at;

    /**
     * @var datetime $updated_at
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     * @Assert\DateTime()
     */
    private $updated_at;

    /**
     * @var $post
     *
     * @ORM\ManyToMany(targetEntity="Trsteel\BlogBundle\Entity\Post", mappedBy="category")
     */
    private $post;

    function __construct()
    {
        $this->post            = new \Doctrine\Common\Collections\ArrayCollection();
        $this->created_at    = new \DateTime();
        $this->updated_at    = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set created_at
     *
     * @param datetime $created_at
     */
    public function setCreatedAt(\DateTime $created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * Get created_at
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param datetime $updated_at
     */
    public function setUpdatedAt(\DateTime $updated_at)
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    /**
     * Get updated_at
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Add post
     *
     * @param Trsteel\BlogBundle\Entity\Post $post
     */
    public function addPost(\Trsteel\BlogBundle\Entity\Post $post)
    {
        $this->post[] = $post;
        return $this;
    }

    /**
     * Get post
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * preUpdate function
     *
     * @ORM\preUpdate
     */
    public function preUpdate()
    {
        $this->updated_at = new \DateTime();
    }
}