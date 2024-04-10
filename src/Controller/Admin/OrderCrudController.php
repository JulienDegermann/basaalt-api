<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Entity\Article;
use App\Traits\CrudActionTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
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
        // $actions
        //     ->remove(Crud::PAGE_INDEX, 'new');

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('stocks', 'Articles'),
            IntegerField::new('quantity', 'Qté'),
        ];
    }
}
