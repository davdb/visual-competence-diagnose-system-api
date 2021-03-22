<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function getUserInforation($user)
    {
        return ['email' => $user->getEmail(), 'group' => $user->getRoles()];
    }
    public function getUserInforationById($id)
    {
        $user = $this->findOneBy(['id' => $id]);
        return ['email' => $user->getEmail(), 'group' => $user->getRoles()];
    }

    public function getAllUsers()
    {
        $users = $this->findAll();
        $output = [];
        foreach ($users as $user) {
            $data = [
                "id" => $user->getId(),
                "email" => $user->getEmail(),
                "age" => $user->getAge(),
                "username" => $user->getUsername(),
                "enabled" => $user->getEnabled() ? "Konto aktywne" : "Konto zablokowane",
                "roles" => ($user->getRoles()[0] == "ROLE_ADMIN" ? "Administrator" : ($user->getRoles()[0] == "ROLE_MODERATOR" ? "Moderator" : "Użytkownik"))
            ];
            $output[] = $data;
        }
        return $output;
    }

    public function save(UserInterface $user)
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function delete(UserInterface $user)
    {
        $this->_em->remove($user);
        $this->_em->flush();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
