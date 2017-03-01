<?php

// src/AppBundle/Entity/User.php
namespace App\Models;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Table(name="users")
 * @Entity
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @Column(type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Column(type="string", length=25, unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @Column(type="string", length=40, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @Column(type="string", length=255)
     */
    private $password;

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
     * @Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * One Product has Many Posts.
     * @var Collection
     * @OneToMany(targetEntity="Post", mappedBy="user")
     */
    private $posts;

    public function __construct($username = null, $password = null)
    {
        $this->username = $username;
        $this->password = $password;

        $this->posts = new ArrayCollection();

        $this->isActive = true;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPosts()
    {
        return $this->posts;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * Post created_at accessor
     */
    public function getCreatedAt()
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

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->username,
            $this->password,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->username,
            $this->password,
            ) = unserialize($serialized);
    }
}