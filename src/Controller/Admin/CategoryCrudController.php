<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Détail de la catégorie')
            ->setEntityLabelInPlural('Liste des catégories');
    }


    public function configureActions(Actions $actions): Actions
    {

        return $actions
            ->update(Crud::PAGE_INDEX, 'new', function (Action $action) {
                return $action->setLabel('Ajouter une catégorie');
            })
            ->update(Crud::PAGE_INDEX, 'edit', function (Action $action) {
                return $action->setLabel('Modifier');
            })
            ->add(Crud::PAGE_INDEX, 'detail')
            ->update(Crud::PAGE_INDEX, 'detail', function (Action $action) {
                return $action->setLabel('Voir');
            });
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom de la catégorie'),
            DateTimeField::new('createdAt', 'Date de création')->setDisabled(true),
            DateTimeField::new('updatedAt', 'Date de modification')->setDisabled(true),
        ];
    }
}
