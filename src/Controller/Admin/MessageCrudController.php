<?php

namespace App\Controller\Admin;

use App\Entity\Message;
use App\Traits\CrudActionTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MessageCrudController extends AbstractCrudController
{
    use CrudActionTrait;

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
        $actions = $this->configureDefaultActions($actions);
        $actions
            ->remove(Crud::PAGE_INDEX, 'new')
            ->remove(Crud::PAGE_INDEX, 'edit')
            ->remove(Crud::PAGE_DETAIL, 'edit');

        return $actions;
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
