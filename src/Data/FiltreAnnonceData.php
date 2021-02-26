<?php

namespace App\Data;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
/* permet de representer le filtre sous forme d'objet*/
class FiltreAnnonceData
{
    /**
     * trier
    **/
    public $tri;
    /**
     * mot clé
     */
    public $q;

    /**
     * les categories selectionnées
     */
    public $categories;

    /**
     * les sous_categories selectionnées
     */
    public $sous_categories;
    /**
     * le prix min
     */
    public $prix_min;
    /**
     * le prix max
     */
    public $prix_max;
    /**
     * les marques
     */
    public $marques;
    
    public function __construct()
    {
        $this->categories=new ArrayCollection();
        $this->sous_categories=new ArrayCollection();
        $this->marques=new ArrayCollection();
    }

    public function getQ(): ?string
    {
        return $this->q;
    }
    
    /**
     * @return Collection|Categorie[]
     */
    public function getCategories() : Collection
    {
        return $this->categories;
    }


    /**
     * @return Collection|SousCategorie[]
     */
    public function getSousCategories() : Collection
    {
        return $this->sous_categories;
    }
    /**
     * @return Collection|Marque[]
     */
    public function getMarques() : Collection
    {
        return $this->marques;
    }
    
    public function getPrixMin(): float
    {
        return $this->prix_min;
    }
    public function getPrixMax(): float
    {
        return $this->prix_max;
    }
    /**
     * @return string
     */
    public function getTri(): string
    {
        return $this->tri;
    }
    
}
