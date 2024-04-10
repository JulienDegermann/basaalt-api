<?php

namespace App\Controller\Admin;

use App\Entity\UserOrder;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

class UserOrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserOrder::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('buyer', 'Acheteur'),
            AssociationField::new('city', 'Ville de livraison'),
            TextField::new('address', 'Adresse de livraison'),
            TextField::new('creditCard', 'Carte de crédit'),
            NumberField::new('totalPrice', 'Prix total (€)'),
            ChoiceField::new('status', 'Statut')
                ->setChoices([
                    'En attente de paiement' => 'payment',
                    'En cours de préparation' => 'payed',
                    'Expédiée' => 'send',
                    'Livrée' => 'recieved',
                    'Annulée' => 'avoided',
                ]),

            CollectionField::new('orders', 'Articles de la commande')
                ->useEntryCrudForm(OrderCrudController::class)


        ];
    }
}
