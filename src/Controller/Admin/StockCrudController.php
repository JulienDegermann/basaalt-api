<?php

namespace App\Controller\Admin;

use App\Entity\Stock;
use App\Form\StockImagesType;
use App\Traits\CrudActionTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class StockCrudController extends AbstractCrudController
{
    use CrudActionTrait;

    public static function getEntityFqcn(): string
    {
        return Stock::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions = $this->configureDefaultActions($actions);

        return $actions;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Détail des stocks de l\'article')
            ->setEntityLabelInPlural('Liste des stocks');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('article', 'Article')->hideOnForm(),
            ChoiceField::new('size', 'Taille')
                ->setChoices([
                    'TU' => 'TU',
                    'XXS' => 'XXS',
                    'XS' => 'XS',
                    'S' => 'S',
                    'M' => 'M',
                    'L' => 'L',
                    'XL' => 'XL',
                    'XXL' => 'XXL',
                    'XXXL' => 'XXXL',
                ]),
            ColorField::new('color', 'Couleur')->setRequired(false)->setFormTypeOptions(['attr' => ['value' => null]]),
            IntegerField::new('quantity', 'Quantité en stock'),
            CollectionField::new('stockImages', 'Images')
                ->setEntryType(StockImagesType::class)
                ->hideOnIndex(),
        ];
    }
}
