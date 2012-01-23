<?php

namespace Trsteel\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Trsteel\BlogBundle\Entity\Post
 *
 * @ORM\Table(name="trsteel_blog_post")
 * @ORM\Entity
 * @ORM\HasLifeCycleCallBacks
 * @ORM\Entity(repositoryClass="Trsteel\BlogBundle\Repository\PostRepository")
 */
class Post
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var date $date
     *
     * @ORM\Column(name="date", type="date")
     * @Assert\NotBlank(message="Please enter a category.")
     * @Assert\Date()
     */
    private $date;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank(message="Please enter a title.")
     */
    private $title;

    /**
     * @var text $body
     *
     * @ORM\Column(name="body", type="text")
     * @Assert\NotBlank(message="Please enter a body.")
     */
    private $body;

    /**
     * @var boolean $is_enabled
     *
     * @ORM\Column(name="is_enabled", type="boolean")
     */
    private $is_enabled;

    /**
     * @var datetime $created_at
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Assert\DateTime()
     */
    private $created_at;

    /**
     * @var datetime $updated_at
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @Assert\DateTime()
     */
    private $updated_at;

    /**
     * @var $category
     *
     * @ORM\ManyToMany(targetEntity="Trsteel\BlogBundle\Entity\Category", inversedBy="post")
     * @ORM\JoinTable(name="trsteel_blog_post_category",
     *    joinColumns={
     *        @ORM\JoinColumn(name="post_id", referencedColumnName="id", onDelete="cascade")
     *    },
     *    inverseJoinColumns={
     *        @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="cascade")
     *    }
     * )
     */
    private $category;

    public function __construct()
    {
        $this->category        = new \Doctrine\Common\Collections\ArrayCollection();
        $this->date            = new \DateTime();
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
     * Set date
     *
     * @param datetime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return datetime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
     * Set body
     *
     * @param text $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Get body
     *
     * @return text 
     */
    public function getBody($limit = null)
    {
        if (!is_null($limit)) {
            return substr(strip_tags($this->body), 0, $limit);
        }
        
        return $this->body;
    }

    /**
     * Set is_enabled
     *
     * @param boolean $isEnabled
     */
    public function setIsEnabled($isEnabled)
    {
        $this->is_enabled = $isEnabled;
    }

    /**
     * Get is_enabled
     *
     * @return boolean 
     */
    public function getIsEnabled()
    {
        return $this->is_enabled;
    }

    /**
     * Set created_at
     *
     * @param datetime $created_at
     */
    public function setCreatedAt(\DateTime $created_at)
    {
        $this->created_at = $created_at;
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
     * Add category
     *
     * @param Trsteel\BlogBundle\Entity\Category $category
     */
    public function addCategory(\Trsteel\BlogBundle\Entity\Category $category)
    {
        $this->category[] = $category;
    }

    /**
     * Get category
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCategory()
    {
        return $this->category;
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