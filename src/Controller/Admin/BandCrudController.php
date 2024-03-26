<?php

namespace App\Controller\Admin;

use App\Entity\Band;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BandCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Band::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Information du groupe')
            ->setEntityLabelInPlural('Information du groupe');
    }


    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, 'new')
            ->update(Crud::PAGE_INDEX, 'edit', function (Action $action) {
                return $action->setLabel('Modifier');
            })
            ->update(Crud::PAGE_INDEX, 'delete', function (Action $action) {
                return $action->setLabel('Supprimer');
            })
            ->add(Crud::PAGE_INDEX, 'detail')
            ->update(Crud::PAGE_INDEX, 'detail', function (Action $action) {
                return $action->setLabel('Voir');
            });
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom du groupe'),
            TextField::new('description'),
            AssociationField::new('bandMember', 'Memnbres du groupe'),
            
        ];
    }
}
