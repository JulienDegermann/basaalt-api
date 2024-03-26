<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, 'new', function (Action $action) {
                return $action->setLabel('Ajouter un article');
            })
            ->update(Crud::PAGE_INDEX, 'edit', function (Action $action) {
                return $action->setLabel('Modifier');
            })
            ->add(Crud::PAGE_INDEX, 'detail')
            ->update(Crud::PAGE_INDEX, 'detail', function (Action $action) {
                return $action->setLabel('Voir');
            });
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
            // IdField::new('id'),
            TextField::new('name', 'Nom de l\'article'),
            TextEditorField::new('description', 'Description'),
            AssociationField::new('category', 'Catégorie'),
            AssociationField::new('stocks', 'Stocks')->onlyOnIndex(),
        ];
    }
}
