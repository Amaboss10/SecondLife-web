<?php

namespace App\Repository;

use App\Entity\CategorieFAQ;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategorieFAQ|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieFAQ|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieFAQ[]    findAll()
 * @method CategorieFAQ[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieFAQRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieFAQ::class);
    }

    // /**
    //  * @return CategorieFAQ[] Returns an array of CategorieFAQ objects
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
    public function findOneBySomeField($value): ?CategorieFAQ
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findCategorieFaqByNom(string $nom_categorie)
    {
        $query=$this->createQueryBuilder('c')
                    ->where('c.nom_categorie = :nom')
                    ->setParameter('nom',$nom_categorie);
        return $query->getQuery()->getOneOrNullResult();
    }
}
