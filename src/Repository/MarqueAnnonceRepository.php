<?php

namespace App\Repository;

use App\Entity\MarqueAnnonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MarqueAnnonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method MarqueAnnonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method MarqueAnnonce[]    findAll()
 * @method MarqueAnnonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarqueAnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MarqueAnnonce::class);
    }

    // /**
    //  * @return MarqueAnnonce[] Returns an array of MarqueAnnonce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MarqueAnnonce
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
