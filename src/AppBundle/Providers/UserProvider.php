<?php namespace AppBundle\Providers;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Doctrine\ORM\EntityManager;
use AppBundle\Models\User;

class UserProvider implements UserProviderInterface
{
    private $conn;

    public function __construct(EntityManager $em)
    {
        $this->conn = $em;
    }

    public function loadUserByUsername($username)
    {

        $stmt = $this->conn->createQuery('select u from AppBundle\Models\User u where u.username = :name')->setParameter('name', strtolower($username));

        if (!$user = $stmt->getOneOrNullResult()) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'AppBundle\Models\User';
    }
}