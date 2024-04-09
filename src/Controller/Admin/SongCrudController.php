<?php

namespace App\Controller\Admin;

use App\Entity\Song;
use App\Traits\CrudActionTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SongCrudController extends AbstractCrudController
{
    use CrudActionTrait;

    public static function getEntityFqcn(): string
    {
        return Song::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Liste des chansons')
            ->setEntityLabelInSingular('Détail de la chanson');
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions = $this->configureDefaultActions($actions);

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre de la chanson'),
            TextField::new('description')->hideOnIndex(),
            AssociationField::new('album', 'Album'),
            DateTimeField::new('releasedAt', 'Date de sortie'),
            // DateTimeField::new('createdAt', 'Date de création'),
            // DateTimeField::new('updatedAt', 'Dernière modification'),
        ];
    }
}
