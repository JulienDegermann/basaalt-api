<?php

namespace App\Controller\Admin;

use App\Entity\AlbumLinks;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AlbumLinksCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AlbumLinks::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [

            AssociationField::new('plateform', 'Plateforme de streaming'),
            TextField::new('url', 'Lien'),
        ];
    }

}
