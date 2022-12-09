<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RencontreRepository;
use App\Repository\TournoiRepository;
use App\Repository\JourneeRepository;
use App\Entity\Tournoi;
use App\Entity\Journee;

class PlanningController extends AbstractController
{
   /**
     * @Route("/planning/affichage_tournois", name="planning_tournoi")
     */
    public function planning(TournoiRepository $TournoiRepository): Response
    {
        return $this->render('planning/index.html.twig', [
            'controller_name' => 'PlanningController',
            'tournois' => $TournoiRepository -> findAll(),

        ]);
    }

    /**
     * @Route("/planning/{tournoi}/affichage_journee", name="planning_journee")
     */
    public function planning_journee(Tournoi $tournoi, JourneeRepository $journeeRepository): Response
    {
        return $this->render('planning/journee.html.twig', [
            'controller_name' => 'PlanningController',
            'tournoi' => $tournoi,
            'journees' => $journeeRepository -> findByTournoi($tournoi),
        ]);
    }
     /**
     * @Route("/planning/{journee}/affichage_rencontre", name="planning_rencontre")
     */
     public function planning_rencontre( Journee $journee, RencontreRepository $rencontreRepository): Response
    {
        return $this->render('planning/rencontre.html.twig', [
            'controller_name' => 'PlanningController',
            'journees' => $journee,
            'rencontres' => $rencontreRepository -> findByJournee($journee),
        ]);
    }
}
