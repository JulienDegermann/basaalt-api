<?php

namespace App\Controller\Admin;

use App\Entity\Plateform;
use App\Traits\CrudActionTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PlateformCrudController extends AbstractCrudController
{
    use CrudActionTrait;

    public static function getEntityFqcn(): string
    {
        return Plateform::class;
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Liste des réseaux sociaux')
            ->setEntityLabelInSingular('Détail du réseau social');
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions = $this->configureDefaultActions($actions);
        $actions
            ->remove(Crud::PAGE_DETAIL, 'delete')
            ->setPermission('new', 'ROLE_ADMIN')
            ->remove(Crud::PAGE_INDEX, 'delete')
            ->remove(Crud::PAGE_INDEX, 'new');

            return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom')->setDisabled(true),
            TextField::new('url', 'Lien'),
            DateTimeField::new('createdAt', 'Date de création')->onlyOnIndex(),
            DateTimeField::new('updatedAt', 'Date de modification')->onlyOnIndex(),
        ];
    }
}
