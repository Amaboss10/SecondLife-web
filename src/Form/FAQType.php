<?php

namespace App\Form;

use App\Entity\Administrateur;
use App\Entity\FAQ;
use App\Entity\CategorieFAQ;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FAQType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre_probleme',TextType::class)
            ->add('description_probleme',TextareaType::class)
            ->add('categorie_faq',EntityType::class,[
                'label'=>'Categorie',
                'required'=>true,
                'class'=>CategorieFAQ::class,
                'choice_label'=>'nomCategorie',
            ])

            //probleme
           /* ->add('id_administrateur',EntityType::class,[
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
            'data_class' => FAQ::class,
        ]);
    }
}
