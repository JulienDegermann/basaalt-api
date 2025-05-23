<?php

namespace App\Controller\Admin;

use App\Entity\Band;
use App\Form\BandMemberType;
use App\Traits\CrudActionTrait;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BandCrudController extends AbstractCrudController
{
    use CrudActionTrait;

    public static function getEntityFqcn(): string
    {
        return Band::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Information du groupe')
            ->setEntityLabelInPlural('Information du groupe');
    }


    public function configureActions(Actions $actions): Actions
    {
        $actions = $this->configureDefaultActions($actions);

        $actions
            ->remove(Crud::PAGE_INDEX, 'new')
            ->remove(Crud::PAGE_INDEX, 'delete')
            ->remove(Crud::PAGE_DETAIL, 'delete');

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom du groupe'),
            TextareaField::new('description'),
            CollectionField::new('bandMember', 'Memnbres du groupe')
                ->setEntryType(BandMemberType::class)
        ];
    }
}
