<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, 'new', function (Action $action) {
                return $action->setLabel('Ajouter un utilisateur');
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

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Détail de l\'utilsateur')
            ->setEntityLabelInPlural('Liste des utilisateurs');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('firstName', 'Prénom'),
            TextField::new('lastName', 'Nom'),
            TextField::new('userName', 'Nom d\'utilisateur'),
            TextField::new('email', 'Email'),
            TextField::new('bandRole', 'Rôle dans le groupe')->hideOnIndex(),
            TextField::new('password', 'Mot de passe')->hideOnIndex()->hideOnDetail(),
            DateTimeField::new('createdAt', 'Date de création')->hideOnIndex()->setDisabled(true),
            DateTimeField::new('updatedAt', 'Date de modification')->hideOnIndex()->setDisabled(true),
            DateTimeField::new('birthDate', 'Date de naissance')->hideOnIndex(),
        ];
    }

}
