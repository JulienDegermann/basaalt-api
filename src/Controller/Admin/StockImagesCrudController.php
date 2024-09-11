<?php

namespace App\Controller\Admin;

use App\Entity\StockImages;
use App\Form\StockImagesType;
use App\Traits\CrudActionTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class StockImagesCrudController extends AbstractCrudController
{
  use CrudActionTrait;

  public static function getEntityFqcn(): string
  {
    return StockImages::class;
  }


  public function configureActions(Actions $actions): Actions
  {
    $actions = $this->configureDefaultActions($actions);

    return $actions;
  }

  public function configureCrud(Crud $crud): Crud
  {
    return $crud
      ->setEntityLabelInSingular('Détail de l\'article')
      ->setEntityLabelInPlural('Liste des articles');
  }

  public function configureFields(string $pageName): iterable
  {
    return [
      TextField::new('file', 'Image')
        ->setFormType(StockImagesType::class)
        ->onlyOnForms(),
      ImageField::new('fileName', 'Image')
        ->setBasePath('/uploads/')
        ->onlyOnIndex()
      // AssociationField::new('stock', 'Stock')
      //   ->setRequired(true)
    ];
  }
}
