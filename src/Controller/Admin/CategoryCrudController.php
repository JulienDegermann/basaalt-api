<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Traits\CrudActionTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoryCrudController extends AbstractCrudController
{
    use CrudActionTrait;
    
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
        $actions = $this->configureDefaultActions($actions);
        
        return $actions;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom de la catégorie'),
            DateTimeField::new('createdAt', 'Date de création')->hideOnForm(),
            DateTimeField::new('updatedAt', 'Date de modification')->hideOnForm(),
        ];
    }
}
