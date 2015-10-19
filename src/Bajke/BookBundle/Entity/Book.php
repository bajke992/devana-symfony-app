<?php

namespace Bajke\BookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Book
 *
 * @Serializer\ExclusionPolicy("all")
 * @ORM\Table(name="book")
 * @ORM\Entity
 */
class Book
{
    /**
     * @var integer
     *
     * @Serializer\Expose
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Serializer\Expose
     * @ORM\Column(unique=true, nullable=false)
     */
    private $title;

    /**
     * @var string
     * @Serializer\Expose
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var User
     *
     * @Serializer\Expose
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="User", inversedBy="books")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $owner;


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
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return User
     */
    public function getOwner() {
        return $this->owner;
    }

    /**
     * @param User $owner
     */
    public function setOwner($owner) {
        $this->owner = $owner;
    }
}

