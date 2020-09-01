<?php

namespace App\Repository;

use App\Entity\UserProposal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserProposal|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserProposal|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserProposal[]    findAll()
 * @method UserProposal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserProposalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserProposal::class);
    }

    // /**
    //  * @return UserProposal[] Returns an array of UserProposal objects
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
    public function findOneBySomeField($value): ?UserProposal
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
