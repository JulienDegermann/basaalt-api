<?php

namespace App\Controller\Admin;

use App\Entity\Message;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MessageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Message::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Détail du message')
            ->setEntityLabelInPlural('Liste des messages');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, 'new')
            ->remove(Crud::PAGE_INDEX, 'edit')

            ->add(Crud::PAGE_INDEX, 'detail')
            ->update(Crud::PAGE_INDEX, 'delete', function (Action $action) {
                return $action->setLabel('Supprimer');
            })
            ->update(Crud::PAGE_INDEX, 'detail', function (Action $action) {
                return $action->setLabel('Voir');
            });
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            DateTimeField::new('createdAt', 'Date d\'envoi'),
            AssociationField::new('author', 'Auteur')
                ->formatValue(function ($value, $entity) {
                    return $entity->getAuthor()->getFirstName() . " " . $entity->getAuthor()->getLastName();
                }),
            TextField::new('text'),
        ];
    }
}
