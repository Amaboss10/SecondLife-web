<?php

namespace App\Form;

use App\Entity\SousCategorie;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SousCategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_sous_categorie',TextType::class)
            ->add('categorie',EntityType::class,[
                'label'=>'Catégories',
                'required'=>true,
                'class'=>Categorie::class,
                'choice_label'=> 'nomCategorie',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SousCategorie::class,
        ]);
    }
}
