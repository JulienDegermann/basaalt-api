<?php

namespace App\Form;

use App\Entity\StockImages;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class StockImagesType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('file', VichImageType::class, [
        'label' => 'Image',
        'required' => false,
        'allow_delete' => false,
        'constraints' => [
          new Assert\Image([
            'maxSize' => '2M',
            'maxSizeMessage' => 'Image invalide : {{ limit }} {{ suffix }}  maximum',
            'mimeTypes' => [
              'image/png',
              'image/jpeg',
              'image/webp',
              'image/jpg'
            ],
            'mimeTypesMessage' => 'Image invalide : les formats acceptés sont JPEG, PNG et WEBP',
          ])
        ]
      ]);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => StockImages::class,
    ]);
  }
}
