<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Entity\Marque;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CreerModifierAnnonceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre_annonce',TextType::class,[
                'label'=>'Titre annonce :',
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'Samsung S8'
                ]
            ])

            ->add('categorie',EntityType::class,[
            'label'=>'Catégorie:',
            'required'=>true,
            'class'=>Categorie::class,
            'choice_label'=> 'nomCategorie',
            ])

            ->add('sous_categorie',EntityType::class,[
                'label'=>'Sous-Catégorie:',
                'required'=>true,
                'class'=>SousCategorie::class,
                'choice_label'=> 'nomSousCategorie',
            ])

            ->add('prix_annonce',NumberType::class,[
                'label'=>'Prix',
                'required'=>true,
                'attr'=>[
                    'placeholder'=>'100'
                ]
            ])

            ->add('marque',EntityType::class,[
                'label'=>'Marques',
                'required'=>true,
                'class'=>Marque::class,
                'choice_label'=>'nomMarque',
            ])

            ->add('poids_annonce',NumberType::class,[
                'label'=>'Poids',
                'required'=>false,
                'attr'=>[
                    'placeholder'=>'1000'
                ]
            ])

            ->add('description_annonce',TextareaType::class,[
                'label'=>'Description :',
                'required'=>true
            ])
            ->add('images_annonce',FileType::class,[
                'label'=>'Images',
                'multiple'=>true,
                'mapped'=>false,
                'required'=>false
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
