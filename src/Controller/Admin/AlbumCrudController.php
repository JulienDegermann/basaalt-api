<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AlbumCrudController extends AbstractCrudController
{
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
        return $actions
            ->update(Crud::PAGE_INDEX, 'new', function (Action $action) {
                return $action->setLabel('Ajouter un album');
            })
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
            // IdField::new('id'),
            TextField::new('title', 'Nom de l\'album'),
            TextEditorField::new('description', 'Description'),
            DateField::new('releasedAt', 'Date de sortie'),
            DateField::new('createdAt', 'Date de création')->hideOnIndex()->setDisabled(true),
            DateField::new('updatedAt', 'Date de modification')->hideOnIndex()->setDisabled(true),
            AssociationField::new('band', 'group')->hideOnIndex(),
            // AssociationField::new('band', 'group')
            //     ->setDisabled(false)
            //     ->setCustomOption('data', $this->$em->getRepository(Band::class)->findOneBy(['id' => 1] ))
            //     ->setValue('basaalt'),
        ];
    }
}
