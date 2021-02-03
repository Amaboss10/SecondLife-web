<?php

namespace App\Repository;

use App\Entity\PhotoAnnonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhotoAnnonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoAnnonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoAnnonce[]    findAll()
 * @method PhotoAnnonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoAnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotoAnnonce::class);
    }

    // /**
    //  * @return PhotoAnnonce[] Returns an array of PhotoAnnonce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PhotoAnnonce
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
