<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Traits\CrudActionTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class CommentCrudController extends AbstractCrudController
{
    use CrudActionTrait;

    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Détail du commentaire')
            ->setEntityLabelInPlural('Liste des commentaires');
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions = $this->configureDefaultActions($actions);

        $actions
            // ->remove(Crud::PAGE_INDEX, 'edit')
            ->remove(Crud::PAGE_INDEX, 'new')
            // ->remove(Crud::PAGE_DETAIL, 'edit')
        ;

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('author', 'Auteur')
                ->formatValue(function ($value, $entity) {
                    return $entity->getAuthor()->getUserName();
                })
                ->setDisabled(true),
            TextField::new('text', 'Commentaire')->setDisabled(true),
            BooleanField::new('isValid', 'Vérifié')->renderAsSwitch(true)
        ];
    }
}
