<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Liste des commandes')
            ->setEntityLabelInSingular('Détail de la commande');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // ->remove(Crud::PAGE_INDEX, 'new')
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
            ChoiceField::new('status')->setChoices([
                'Réception en cours' => 'not recieved',
                'Paiement en attente' => 'payment required',
                'Expédiée' => 'send',
                'Livrée' => 'recieved',
                'Annulée' => 'aborted',
            ]),
            DateTimeField::new('createdAt', 'Date de création')->setDisabled(true),
            DateTimeField::new('updatedAt', 'Date de modification')->setDisabled(true),
            AssociationField::new('buyer', 'Acheteur'),
            AssociationField::new('stock', 'Quantité de produits'),

        ];
    }
}
