<?php

namespace App\Form;

use App\Entity\BandMember;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class BandMemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'required' => true,
                'attr' => [
                    'placeholder' => 'John'
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Doe'
                ]
            ])
            ->add('bandRole', TextType::class, [
                'label' => 'Rôle dans le groupe',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Mutli-tache'
                ]
            ])
            ->add('birthdate', DateType::class, [
                'label' => 'Date de naissance',
                'required' => false,
                'widget' => 'single_text'
            ])
            ->add('file', VichImageType::class, [
                'label' => 'Photo',
                'required' => false,
                'download_uri' => false,
                'image_uri' => true, // Affiche l’image actuelle
                'allow_delete' => true, // Active la case à cocher de suppression
                'delete_label' => 'Supprimer la photo',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BandMember::class,
        ]);
    }
}
