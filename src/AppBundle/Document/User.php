<?php

namespace Sparse\AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * The current user.
 *
 * @author Raymond Jelierse <raymond@shareworks.nl>
 *         
 * @MongoDB\Document(collection="users")
 */
class User implements UserInterface, EquatableInterface
{
    /**
     * @MongoDB\Id()
     * @Serializer\Type("string")
     * @Serializer\ReadOnly()
     */
    private $id;

    /**
     * @MongoDB\Collection()
     * @Serializer\Type("array<string>")
     * @Serializer\ReadOnly()
     * @Serializer\Exclude()
     */
    private $roles;

    /**
     * @MongoDB\String()
     * @Serializer\Type("string")
     * @Serializer\ReadOnly()
     * @Serializer\Exclude()
     */
    private $password;

    /**
     * @MongoDB\String()
     * @Serializer\Type("string")
     * @Serializer\ReadOnly()
     * @Serializer\Exclude()
     */
    private $salt;

    /**
     * @MongoDB\String()
     * @MongoDB\UniqueIndex()
     * @Serializer\Type("string")
     * @Serializer\ReadOnly()
     */
    private $username;
    
    public static function create($username)
    {
        return new static($username);
    }
    
    public function __construct($username)
    {
        $this->username = $username;
        $this->salt = md5(uniqid($username, true));
        $this->roles = ['ROLE_USER'];
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function isEqualTo(UserInterface $user)
    {
        if ($this->username !== $user->getUsername()) {
            return false;
        }
        
        if ($this->password !== $user->getPassword()) {
            return false;
        }
        
        return true;
    }
}
