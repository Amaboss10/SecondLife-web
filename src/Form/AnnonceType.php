<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre_annonce',TextType::class)
            ->add('description_annonce',TextareaType::class)
            ->add('prix_annonce',NumberType::class)
            ->add('poids_annonce',NumberType::class)
            //->add('etat_annonce')
            //->add('date_publi_annonce')
            //->add('est_valide')
            ->add('categorie',EntityType::class,[
                'label'=>'Catégorie',
                'required'=>true,
                'class'=>Categorie::class,
                'choice_label'=> 'nomCategorie',
            ])
            ->add('marque',EntityType::class,[
                'label'=>'Marque',
                'required'=>true,
                'class'=>Categorie::class,
                'choice_label'=> 'nomMarque',
            ])
            ->add('sous_categorie',EntityType::class,[
                'label'=>'Sous-Catégorie',
                'required'=>true,
                'class'=>SousCategorie::class,
                'choice_label'=> 'nomSousCategorie',
            ])
            //->add('utilisateur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
