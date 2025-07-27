<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Traits\CrudActionTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

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

        $actions
            ->update(Crud::PAGE_INDEX, 'delete', function (Action $action) {
                return $action->displayIf(function ($entity) {
                    if ($this->isGranted('ROLE_SUPER_ADMIN')) {
                        return !in_array('ROLE_SUPER_ADMIN', $entity->getRoles(), true) ||
                            $this->getUser() === $entity;
                    }

                    if ($this->isGranted('ROLE_ADMIN')) {
                        return $this->getUser() === $entity;
                    }
                    return false;
                });
            })
            ->update(Crud::PAGE_DETAIL, 'delete', function (Action $action) {
                return $action->displayIf(function ($entity) {
                    if ($this->isGranted('ROLE_SUPER_ADMIN')) {
                        return !in_array('ROLE_SUPER_ADMIN', $entity->getRoles(), true) ||
                            $this->getUser() === $entity;
                    }

                    if ($this->isGranted('ROLE_ADMIN')) {
                        return $this->getUser() === $entity;
                    }
                    return false;
                });
            })
            ->update(Crud::PAGE_INDEX, 'edit', function (Action $action) {
                return $action->displayIf(function ($entity) {
                    if ($this->isGranted('ROLE_SUPER_ADMIN')) {
                        return !in_array('ROLE_SUPER_ADMIN', $entity->getRoles(), true) || $this->getUser() === $entity;
                    }

                    if ($this->isGranted('ROLE_ADMIN')) {
                        return (!in_array('ROLE_SUPER_ADMIN', $entity->getRoles(), true) &&
                            !in_array('ROLE_ADMIN', $entity->getRoles(), true) || $this->getUser() === $entity);
                    }
                    return false;
                });
            })
            ->update(Crud::PAGE_DETAIL, 'edit', function (Action $action) {
                return $action->displayIf(function ($entity) {
                    if ($this->isGranted('ROLE_SUPER_ADMIN')) {
                        return !in_array('ROLE_SUPER_ADMIN', $entity->getRoles(), true) || $this->getUser() === $entity;
                    }

                    if ($this->isGranted('ROLE_ADMIN')) {
                        return (!in_array('ROLE_SUPER_ADMIN', $entity->getRoles(), true) &&
                            !in_array('ROLE_ADMIN', $entity->getRoles(), true) || $this->getUser() === $entity);
                    }
                    return false;
                });
            })
            ->update(CRUD::PAGE_INDEX, 'detail', function (Action $action) {
                return $action->displayIf(function ($entity) {
                    if ($this->isGranted('ROLE_SUPER_ADMIN')) {
                        return !in_array('ROLE_SUPER_ADMIN', $entity->getRoles(), true) ||
                            $this->getUser() === $entity;
                    }

                    if ($this->isGranted('ROLE_ADMIN')) {
                        return (!in_array('ROLE_SUPER_ADMIN', $entity->getRoles(), true) &&
                            !in_array('ROLE_ADMIN', $entity->getRoles(), true) || $this->getUser() === $entity);
                    }

                    return false;
                });
            })
        ;


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

        $roles = [
            'Visiteur' => 'ROLE_USER',
            'Client' => 'ROLE_CLIENT',
            'Administrateur' => 'ROLE_ADMIN',
        ];

        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            $roles['Super Admin'] = 'ROLE_SUPER_ADMIN';
        }

        return [
            TextField::new('firstName', 'Prénom')->setFormTypeOption('disabled', true),
            TextField::new('lastName', 'Nom')->setFormTypeOption('disabled', true),
            TextField::new('userName', 'Pseudo')->setFormTypeOption('disabled', true),
            TextField::new('email', 'Email')->setPermission('ROLE_SUPER_ADMIN'),
            DateTimeField::new('createdAt', 'Date de création')->hideOnForm(),
            DateTimeField::new('updatedAt', 'Date de modification')->onlyOnDetail(),
            TextField::new('password', 'Mot de passe')->onlyOnForms()->onlyWhenCreating(),
            TextField::new('address', 'Adresse')->hideOnIndex()->onlyWhenCreating(),
            AssociationField::new('city', 'Ville')
                ->hideOnIndex()
                ->onlyWhenCreating(),
            BooleanField::new('isValid', 'Vérifié')
                ->renderAsSwitch(false),
            ChoiceField::new('roles', 'Rôles')
                ->setChoices($roles)
                ->allowMultipleChoices()
        ];
    }
}
