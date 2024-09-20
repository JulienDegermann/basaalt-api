<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Traits\CrudActionTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

class OrderCrudController extends AbstractCrudController
{
    use CrudActionTrait;

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
        $actions = $this->configureDefaultActions($actions);
        // $actions
        //     ->remove(Crud::PAGE_INDEX, 'new');

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            CollectionField::new('articleCommands', 'Commandes')
                ->useEntryCrudForm(),
            ChoiceField::new('status', 'Statut')
                ->setChoices([
                    'Sauvegardée' => 'saved',
                    'Paiement réglé' => 'paymentValid',
                    'Paiement bloqué' => 'paymentNotValid',
                    'Commande envoyée' => 'send',
                    'Commande reçue' => 'recieved',
                    'Commande retournée' => 'back'
                ])
//            AssociationField::new('userOrder', 'Client')

        ];
    }
}