<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Traits\CrudActionTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

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
            ->setEntityLabelInSingular('Détail de la commande')
            ->setDefaultSort(['status' => 'ASC', 'updatedAt' => 'DESC', 'updatedAt' => 'DESC']);
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
            ChoiceField::new('status', 'Statut')
                ->setChoices([
                    'Sauvegardée' => 'saved',
                    'Paiement réglé' => 'paymentValid',
                    'Paiement bloqué' => 'paymentNotValid',
                    'Commande expédiée' => 'send',
                    'Commande reçue' => 'recieved',
                    'Commande retournée' => 'back',
                ]),
            DateTimeField::new('createdAt', 'Création')
                ->hideOnIndex()
                ->hideOnForm(),
            DateTimeField::new('updatedAt', 'Modification')
                ->hideOnForm(),
            AssociationField::new('buyer', 'Client')
                ->hideOnIndex()
                ->hideWhenUpdating(),
            CollectionField::new('articleCommands', 'Articles de la commande')
                ->hideWhenUpdating()
                ->useEntryCrudForm(),
            NumberField::new('totalPrice', 'Montant total (€)')
                ->hideWhenUpdating()
                ->onlyOnIndex(),
            TextField::new('address', 'Adresse de livraison')
                ->hideWhenUpdating(),
            AssociationField::new('city', 'Ville de livraison')
                ->hideWhenUpdating(),
            TextField::new('deliveryUrl', 'Lien de suivi de commande')
                ->hideOnIndex(),
            DateField::new('expectedDeliveryDate', 'Date de livraison estimée')
                ->hideOnIndex(),
        ];
    }
}