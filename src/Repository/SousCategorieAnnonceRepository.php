<?php

namespace App\Repository;

use App\Entity\SousCategorieAnnonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SousCategorieAnnonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method SousCategorieAnnonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method SousCategorieAnnonce[]    findAll()
 * @method SousCategorieAnnonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SousCategorieAnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SousCategorieAnnonce::class);
    }

    // /**
    //  * @return SousCategorieAnnonce[] Returns an array of SousCategorieAnnonce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SousCategorieAnnonce
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
