<?php

namespace App\Controller\Admin;

use App\Entity\SongLinks;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SongLinksCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SongLinks::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setDefaultSort(['url' => 'DESC']);
    
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('plateform', 'Plateforme de streaming'),
            AssociationField::new('song', 'Chanson'),
            TextField::new('url', 'Lien'),
        ];
    }
}
