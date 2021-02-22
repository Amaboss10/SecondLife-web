<?php

namespace App\Repository;

use App\Entity\Marque;
use App\Entity\Annonce;
use App\Entity\Utilisateur;
use App\Data\FiltreAnnonceData;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    // /**
    //  * @return Annonce[] Returns an array of Annonce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Annonce
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


public function findAnnoncesDisponibles(){
    $query=$this->createQueryBuilder('a')
                    ->where('a.etat_annonce = :etat')
                    ->orderBy('a.date_publi_annonce','DESC')
                    ->setParameter('etat','Disponible');
    return $query->getQuery()->getResult();
}

public function findMesAnnonces(Utilisateur $utilisateur){
    $query=$this->createQueryBuilder('a')
                    ->where('a.utilisateur = :user')
                    ->orderBy('a.date_publi_annonce','DESC')
                    ->setParameter('user',$utilisateur);
    return $query->getQuery()->getResult();
}

public function findAnnoncesByMarque(Marque $marque)
{
    $query=$this->createQueryBuilder('a')
                ->where('a.marque = :marque')
                ->orderBy('a.date_publi_annonce','DESC')
                ->setParameter('marque',$marque);
    return $query->getQuery()->getResult();
}
public function findXAnnoncesNotUtilisateur(int $nombre,Utilisateur $user){
    $query=$this->createQueryBuilder('a')
                ->where('a.utilisateur <> :user')
                ->orderBy('a.date_publi_annonce','DESC')
                ->setParameter('user',$user)
                ->setMaxResults($nombre);

    return $query->getQuery()->getResult();
}
public function findAnnonceAleat()
    {
        return $this->createQueryBuilder('m')
                    //->orderBy('RAND()')
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getResult();
    }


public function findAnnoncesFiltrees(FiltreAnnonceData $search)
    {   
         $query=$this->createQueryBuilder('a')
                    ->where('a.etat_annonce = :etat')
                    ->setParameter('etat','pas vendu');
        //tri
        if(!empty($search->tri)){
            if($search->tri==='prix_croissant'){
                $query->orderBy('a.prix_annonce','ASC');
            }
            else if($search->tri==='prix_decroissant'){
                $query->orderBy('a.prix_annonce','DESC');
            }
            else if($search->tri==='plus_recent'){
                $query->orderBy('a.date_publi_annonce','DESC');
            }
            else if($search->tri==='plus_ancien'){
                $query->orderBy('a.prix_annonce','ASC');
            }
            else{
                $query->orderBy('a.prix_annonce','DESC');
            }

        }
        else
        {
            $query->orderBy('a.date_publi_annonce','DESC');
        }
        //mot clé
        if(!empty($search->q)){
            $query=$query
                ->andWhere('a.titre_annonce LIKE :q 
                OR a.description_annonce LIKE :q  
                OR a.poids_annonce LIKE :q
                OR a.lieu LIKE :q
                OR a.mode_livraison LIKE :q
                ')
                ->setParameter('q',$search->q);
        }
        //categorie
        if(!empty($search->categories)){
            $query=$query
                ->andWhere('a.categorie IN (:categories)')
                ->setParameter('categories',$search->categories);
        }
        
        //souscategorie
        if(!empty($search->sous_categories)){
            $query=$query
                ->andWhere('a.sous_categorie IN (:sous_categories)')
                ->setParameter('sous_categories',$search->sous_categories);
        }
        
        //marque
        if(!empty($search->marques)){
            $query=$query
                ->andWhere('a.marque IN (:marques)')
                ->setParameter('marques',$search->marques);
        }
        
        //mode de livraison
        if(!empty($search->modes_livraison)){
            $query=$query
                ->andWhere('a.mode_livraison IN (:modes_livraison)')
                ->setParameter('modes_livraison',$search->modes_livraison);
        }
        
        //prix min
        if(!empty($search->prix_min)){
            $query=$query
                ->andWhere('a.prix_annonce >= :min')
                ->setParameter('min',$search->prix_min);
        }
        //prix max
        if(!empty($search->prix_max)){
            $query=$query
                ->andWhere('a.prix_annonce <= :max')
                ->setParameter('max',$search->prix_max);
        }

        //lieux
        if(!empty($search->lieux)){
            $query=$query
                ->andWhere('a.lieu LIKE :lieux')
                ->setParameter('lieux','%{search->lieux}%');
        }
        return $query->getQuery()->getResult();
        
        /*return $this->paginator->paginate(
            $query,
            1,
            15 //nb elements par page
        );*/
    }
    
}