<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_personne')
            ->add('prenom_personne')
            ->add('mail_personne')
            ->add('mdp_personne')
            ->add('lien_image_personne')
            ->add('pseudo_user')
            ->add('adresse_user')
            ->add('date_naiss_user')
            ->add('date_inscription_user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
