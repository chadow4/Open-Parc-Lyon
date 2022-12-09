<?php

namespace App\Controller\Admin;

use App\Entity\Journee;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class JourneeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Journee::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            DateTimeField::new('date'),
            TextField::new('type_court'),
            IntegerField::new('billet_gradin_haut'),
            IntegerField::new('billet_gradin_bas'),
            IntegerField::new('billet_loge'),
            AssociationField::new('tournoi'),
        ];
    }
}
