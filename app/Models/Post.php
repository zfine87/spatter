<?php

// app/Models/User.php
namespace App\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @Table(name="posts")
 * @Entity
 */
class Post implements \Serializable
{
    /**
     * @Column(type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Column(type="integer", length=25)
     * @Assert\NotBlank()
     */
    private $user_id;

    /**
     * @Column(type="string", length=140)
     * @Assert\NotBlank()
     */
    private $body;


    /**
     * @Column(type="datetime", nullable=false)
     * @Version
     * @Assert\NotBlank()
     */
    private $created_at;

    /**
     * @Column(type="datetime", nullable=false)
     * @Version
     * @Assert\NotBlank()
     */
    private $updated_at;

    /**
     * Many Posts have One User.
     * @ManyToOne(targetEntity="User", inversedBy="posts")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user = null)
    {
        $this->user = $user;
    }

    /**
     * Post body accessor
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Post body mutator
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Post created_at accessor
     */
    public function getcreated_at()
    {
        return $this->created_at;
    }

    /**
     * Post created_at mutator
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * Post updated_at accessor
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Post updated_at mutator
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }


    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->user_id,
            $this->body
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->user_id,
            $this->body,
            $this->created_at,
            $this->updated_at
            ) = unserialize($serialized);
    }
}