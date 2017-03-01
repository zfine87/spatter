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
            $this->body
            ) = unserialize($serialized);
    }
}