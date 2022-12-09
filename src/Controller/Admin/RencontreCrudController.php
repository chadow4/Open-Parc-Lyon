<?php

namespace App\Controller\Admin;

use App\Entity\Rencontre;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class RencontreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Rencontre::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('score'),
            AssociationField::new('journee'),
            DateTimeField::new('date_debut'),
            AssociationField::new('journee'),
            AssociationField::new('equipes')->formatValue(function ($value, $entity) {
                $equipes = $entity->getEquipes();
                $result1 = '';
                $joueurs1 = $equipes[0]->getJoueurs();
                foreach ($joueurs1 as $joueur) {
                    if(strlen($result1) != 0) $result1 .= ' && ';
                    $result1 .= $joueur->getNom();
                }

                $result2 = '';
                $joueurs2 = $equipes[1]->getJoueurs();
                foreach ($joueurs2 as $joueur) {
                    if(strlen($result2) != 0) $result2 .= ' && ';
                    $result2 .= $joueur->getNom();
                }

                return $result1 .' contre '. $result2;
            }),
            AssociationField::new('court'),
            AssociationField::new('arbitres'),
            AssociationField::new('ramasseurs'),
        ];
    }
    
}
