<?php

namespace App\Form;

use App\Data\FiltreAnnonceData;
use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Entity\Marque;
use App\Repository\CategorieRepository;
use App\Repository\MarqueRepository;
use App\Repository\SousCategorieRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchAnnonceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tri',ChoiceType::class,[
                'label'=>'Trier par :',
                'required'=>false,
                'choices'=>[
                    
                    'Prix croissant'=>'prix_croissant',
                    'Prix decroissant'=>'prix_decroissant',
                    'Plus recent'=>'plus_recent',
                    'Plus ancien'=>'plus_ancien'
                ]
            ])
            ->add('q',TextType::class,[
                'label'=>'Recherche par mot clé',
                'required'=>false,
                'attr'=>[
                    'placeholder'=> 'Rechercher un mot clé'
                ]
            ])
            ->add('categories',EntityType::class,[
                'label'=>'Catégories',
                'required'=>false,
                'class'=>Categorie::class,
                'choice_label'=> 'nomCategorie',
                'multiple'=>true,
            ])
            ->add('sous_categories',EntityType::class,[
                'label'=>'Sous-Catégories',
                'required'=>false,
                'class'=>SousCategorie::class,
                'choice_label'=> 'nomSousCategorie',
                'multiple'=>true,
            ])
            ->add('prix_min',NumberType::class,[
                'label'=>false,
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'Prix min'
                ]
            ])
            ->add('prix_max',NumberType::class,[
                'label'=>false,
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'Prix max'
                ]
            ])
            ->add('modes_livraison',ChoiceType::class,[
                'label'=>'Modes de livraison',
                'required'=>false,
                'choices'=>[
                    'Remise en main propre'=>'remise_en_main_propre',
                    'Remise via transporteur(poste, collissimo,..)'=>'remise_via_transporteur'
                ]
            ])
            ->add('marques',EntityType::class,[
                'label'=>'Marques',
                'required'=>false,
                'class'=>Marque::class,
                'multiple'=>true,
                'choice_label'=>'nomMarque',
                
            ])
            ->add('lieux',TextType::class,[
                'label'=>'Ville',
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'Ville ou Departement ou Region'
                ]
            ])
            ->add('save',SubmitType::class,['label'=>'Rechercher'])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=>FiltreAnnonceData::class,
            'method'=>'GET',
            'csrf_protection'=>false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}