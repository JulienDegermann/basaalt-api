<?php

namespace App\Controller\Admin;

use App\Entity\ArticleCommand;
use App\Traits\CrudActionTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class ArticleCommandCrudController extends AbstractCrudController
{
    use CrudActionTrait;

    public static function getEntityFqcn(): string
    {
        return ArticleCommand::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Command')
            ->setEntityLabelInPlural('Commandes');
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions = $this->configureDefaultActions($actions);

//        $actions
//            ->remove(Crud::PAGE_INDEX, 'new')
//            ->remove(Crud::PAGE_INDEX, 'delete')
//            ->remove(Crud::PAGE_DETAIL, 'delete');

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('stock', 'Stock'),
            IntegerField::new('quantity', 'Quantité'),
        ];
    }
}
