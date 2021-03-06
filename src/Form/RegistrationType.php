<?php

namespace App\Form;


use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_personne')
            ->add('prenom_personne')
            ->add('mail_personne', EmailType::class)
            ->add('mdp_personne', PasswordType::class)
            ->add('verif_mdp_personne', PasswordType::class)
            ->add('pseudo_user')
            ->add('adresse_user')
            ->add('date_naiss_user', DateType::class)
            ->add('lien_image_personne', FileType::class, [
                'required' => false,
                'mapped'=>false,
            ])
        ;
    }

 

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
