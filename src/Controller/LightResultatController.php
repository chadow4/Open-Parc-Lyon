<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Joueur;
use App\Entity\Equipe;
use App\Entity\Rencontre;
use App\Repository\RencontreRepository;


class LightResultatController extends AbstractController
{
    /**
     * @Route("/light/resultat", name="light.resultat")
     */
    public function index(ManagerRegistry $doctrine, RencontreRepository $rencontreRepo): Response
    {
        $joueurs= array();
        $rencontres = $rencontreRepo->findRecentRencontre();
        foreach($rencontres as $rencontre){
            array_push($joueurs, $this->getJoueurByRencontre($doctrine, $rencontre));
        
        }

        return $this->render('light_resultat/index.html.twig', [
            'controller_name' => 'LightResultatController',
            'rencontres' => $rencontres,
            'joueurs' => $joueurs
        ]);
    }

    public function getJoueurByRencontre(ManagerRegistry $doctrine, Rencontre $rencontre)
    {
        $entityManager = $doctrine->getManager();
    
        $equipes = $rencontre->getEquipes();
        $equipe1 = $equipes[0]->getJoueurs();
        $equipe2 = $equipes[1]->getJoueurs();
        return(array("equipe1"=> $equipe1, "equipe2"=> $equipe2));
    }
}
