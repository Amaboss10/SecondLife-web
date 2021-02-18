<?php

namespace App\Form;

use App\Entity\CategorieFAQ;
use App\Entity\Administrateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieFAQType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_categorie',TextType::class)
            /*->add('id_administrateur',EntityType::class,[
                'label'=>'administrateur',
                'required'=>true,
                'class'=>Administrateur::class,
                'choice_label'=>'nomAdmin',
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CategorieFAQ::class,
        ]);
    }
}
