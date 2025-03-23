<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Traits\CrudActionTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    use CrudActionTrait;

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions = $this->configureDefaultActions($actions);

        return $actions;
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
            DateTimeField::new('createdAt', 'Date de création')->onlyOnIndex(),
            DateTimeField::new('updatedAt', 'Date de modification')->onlyOnIndex(),
            // DateTimeField::new('birthDate', 'Date de naissance')->hideOnIndex(),
            TextField::new('address', 'Adresse')->hideOnIndex(),
            AssociationField::new('city', 'Ville')
                ->hideOnIndex(),
            ChoiceField::new('roles', 'Rôles')
                ->setChoices([
                    'Visiteur' => 'ROLE_USER',
                    'Client' => 'ROLE_CLIENT',
                    'Administrateur' => 'ROLE_ADMIN',
                    'Super Admin' => 'ROLE_SUPER_ADMIN',
                ])
                ->allowMultipleChoices(),
        ];
    }
}
