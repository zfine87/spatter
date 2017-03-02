<?php namespace AppBundle\Models;

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
     * @Column(name="created_at", type="datetime", nullable=false)
     * @Version
     * @Assert\NotBlank()
     */
    private $createdAt;

    /**
     * @Column(name="updated_at", type="datetime", nullable=false)
     * @Version
     * @Assert\NotBlank()
     */
    private $updatedAt;

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
     *
     * @param $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Post createdAt accessor
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Post createdAt mutator
     *
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Post updatedAt accessor
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Post updatedAt mutator
     *
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }


    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->user_id,
            $this->body,
            $this->created_at,
            $this->updated_at
        ]);
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