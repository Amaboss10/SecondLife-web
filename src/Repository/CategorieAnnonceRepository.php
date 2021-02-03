<?php

namespace App\Repository;

use App\Entity\CategorieAnnonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategorieAnnonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieAnnonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieAnnonce[]    findAll()
 * @method CategorieAnnonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieAnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieAnnonce::class);
    }

    // /**
    //  * @return CategorieAnnonce[] Returns an array of CategorieAnnonce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategorieAnnonce
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
