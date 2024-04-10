<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use App\Traits\CrudActionTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AlbumCrudController extends AbstractCrudController
{
    use CrudActionTrait;
    
    public static function getEntityFqcn(): string
    {
        return Album::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Liste des albums')
            ->setEntityLabelInSingular('Détail de l\'album');
    }
    
    public function configureActions(Actions $actions): Actions
    {
        $actions = $this->configureDefaultActions($actions);

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            // IdField::new('id'),
            TextField::new('title', 'Nom de l\'album'),
            DateField::new('releasedAt', 'Date de sortie'),
            TextareaField::new('description', 'Description'),
            DateField::new('createdAt', 'Date de création')->onlyOnDetail(),
            DateField::new('updatedAt', 'Date de modification')->onlyOnDetail(),
            AssociationField::new('band', 'Groupe')->hideOnIndex(),
            CollectionField::new('albumLinks', 'Liens')
                ->useEntryCrudForm(AlbumLinksCrudController::class)
        ];
    }
}
