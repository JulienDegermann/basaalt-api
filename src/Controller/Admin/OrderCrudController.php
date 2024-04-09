<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Traits\CrudActionTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

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
        $actions
            ->remove(Crud::PAGE_INDEX, 'new');

        return $actions;
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
            DateTimeField::new('createdAt', 'Date de création')->hideOnForm(),
            DateTimeField::new('updatedAt', 'Date de modification')->hideOnForm(),
            AssociationField::new('buyer', 'Acheteur')->setDisabled(true),
            AssociationField::new('stock', 'Quantité de produits')->setDisabled(true),

        ];
    }
}
