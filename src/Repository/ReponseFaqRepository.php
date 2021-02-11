<?php

namespace App\Repository;

use App\Entity\ReponseFaq;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReponseFaq|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReponseFaq|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReponseFaq[]    findAll()
 * @method ReponseFaq[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReponseFaqRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReponseFaq::class);
    }

    // /**
    //  * @return ReponseFaq[] Returns an array of ReponseFaq objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReponseFaq
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
