<?php

namespace App\Controller\Admin;

use App\Entity\Live;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LiveCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Live::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Liste des concerts')
            ->setEntityLabelInSingular('Détail du concert');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, 'new', function (Action $action) {
                return $action->setLabel('Ajouter un concert');
            })
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
            TextField::new('eventName', 'Évènement'),
            DateTimeField::new('eventDate', 'Date'),
            AssociationField::new('city', 'Ville'),
            TextField::new('address', 'Adresse'),
            DateTimeField::new('updatedAt', 'Dernière modification')->onlyOnIndex()
        ];
    }
}
