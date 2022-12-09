<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RencontreRepository;
use App\Repository\TournoiRepository;
use App\Repository\JourneeRepository;
use App\Repository\BilletRepository;
use App\Repository\PanierRepository;
use App\Entity\Tournoi;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Journee;
use Symfony\Component\HttpFoundation\Request;

class BilletterieController extends AbstractController
{
    /**
     * @Route("/billetterie/choix_tournoi", name="billetterie_tournoi")
     */
    public function tournoi(TournoiRepository $tournoiRepository): Response
    {
        $tournois = $tournoiRepository->findCurrentTournoi();
        return $this->render('billetterie/tournoi.html.twig', [
            'controller_name' => 'BilletterieController',
            'tournois' => $tournois
        ]);
    }

    /**
     * @Route("/billetterie/{tournoi}/choix_journee", name="billetterie_journee")
     */
    public function journee(Tournoi $tournoi, JourneeRepository $journeeRepository): Response
    {
        $journees = $journeeRepository->findFuturJournee($tournoi);
        return $this->render('billetterie/journee.html.twig', [
            'controller_name' => 'JourneeController',
            'tournoi' => $tournoi,
            'journees' => $journees,
        ]);
    }

    /**
     * @Route("/billetterie/{journee}/choix_gradin", name="billetterie_gradin")
     */
    public function gradin(Journee $journee, BilletRepository $billetRepository): Response
    {
        return $this->render('billetterie/gradin.html.twig', [
            'controller_name' => 'JourneeController',
            'journee' => $journee,
            'billets_restant' => $billetRepository->getCountBilletRestant($journee),
        ]);
    }

    /**
     * @Route("/billetterie/{journee}/{gradin}/choixbillet", name="billetterie_choixbillet")
     */
    public function choixBillet(ManagerRegistry $doctrine, Request $request, Journee $journee, String $gradin, BilletRepository $billetRepository, PanierRepository $panierRepository): Response
    {
        $panier = $panierRepository->findByUser($this->getUser());

        if($request->get('action') == '+'){
            $billetUpdate = $billetRepository->getOneBilletRestantGradin($journee, $gradin);
            $billetUpdate[0]->setPanier($panier[0]);
            $billetUpdate[0]->setType($request->get('billet_type'));
            $panier[0]->setPrix($panier[0]->getPrix() + $request->get('billet_prix'));
            $doctrine->getManager()->flush();
        }

        $billets = $billetRepository->getBilletRestantGradin($journee, $gradin);
        $typeBillets = $this->getPrix($journee, $gradin);
        
        return $this->render('billetterie/choix_billet.html.twig', [
            'controller_name' => 'JourneeController',
            'typeBillets' => $typeBillets,
            'panier' => $panier,
            'gradin' => $gradin,
        ]);
    }

    /**
     * @Route("/billetterie/panier", name="billetterie_panier")
     */
    public function Panier(ManagerRegistry $doctrine, Request $request, BilletRepository $billetRepository, PanierRepository $panierRepository): Response
    {
        $panier = $panierRepository->findByUser($this->getUser());
        
        return $this->render('billetterie/panier.html.twig', [
            'controller_name' => 'JourneeController',
            'panier' => $panier,
        ]);
    }

    
    /**
     * @Route("/paiment", name="billetterie_paiment")
     */
    public function paiment(): Response
    {

        return $this->render('billetterie/paiement.html.twig', [

            'controller_name' => 'JourneeController',
        ]);
    }




    private function getPrix($journee, $gradin) {
        $typeBillets = array();
        switch ($journee->getDate()->format('l')) {
            case 'Monday': 
                if($gradin == "Gradin Haut"){
                    $typeBillets[0] = ['type' => 'Billet Grand Public', 'prix' => 25];
                    $typeBillets[1] = ['type' => 'Billet Grand Public -12 ans', 'prix' => 20];
                    $typeBillets[2] = ['type' => 'Billet Licenciés', 'prix' => round(25-25*0.17, 2)];
                    $typeBillets[3] = ['type' => 'Billet Journée de la Solidarité', 'prix' => round(25-25*0.3, 2)];
                } else if ($gradin == "Gradin Bas") {
                    $typeBillets[0] = ['type' => 'Billet Grand Public', 'prix' => 30];
                    $typeBillets[1] = ['type' => 'Billet Licenciés', 'prix' => round(30-30*0.17, 2)];
                    $typeBillets[2] = ['type' => 'Billet Journée de la Solidarité', 'prix' => round(30-30*0.3, 2)];
                } else if ($gradin == "Loge") {
                    $typeBillets[0] = ['type' => 'Billet Grand Public', 'prix' => 40];
                    $typeBillets[1] = ['type' => 'Billet Licenciés', 'prix' => round(40-40*0.17, 2)];
                    $typeBillets[2] = ['type' => 'Billet Journée de la Solidarité', 'prix' => round(40-40*0.3, 2)];
                }
                break;
            case 'Tuesday':
                if($gradin == "Gradin Haut"){
                    $typeBillets[0] = ['type' => 'Billet Grand Public', 'prix' => 25];
                    $typeBillets[1] = ['type' => 'Billet Grand Public -12 ans', 'prix' => 20];
                    $typeBillets[2] = ['type' => 'Billet Licenciés', 'prix' => round(25-25*0.17, 2)];
                    $typeBillets[3] = ['type' => 'Billet Journée de la Solidarité', 'prix' => round(25-25*0.3, 2)];
                } else if ($gradin == "Gradin Bas") {
                    $typeBillets[0] = ['type' => 'Billet Grand Public', 'prix' => 30];
                    $typeBillets[1] = ['type' => 'Billet Licenciés', 'prix' => round(30-30*0.17, 2)];
                    $typeBillets[2] = ['type' => 'Billet Journée de la Solidarité', 'prix' => round(30-30*0.3, 2)];
                } else if ($gradin == "Loge") {
                    $typeBillets[0] = ['type' => 'Billet Grand Public', 'prix' => 40];
                    $typeBillets[1] = ['type' => 'Billet Licenciés', 'prix' => round(40-40*0.17, 2)];
                    $typeBillets[2] = ['type' => 'Billet Journée de la Solidarité', 'prix' => round(40-40*0.3, 2)];
                }
                break;
            case 'Wednesday':
                if($gradin == "Gradin Haut"){
                    $typeBillets[0] = ['type' => 'Billet Grand Public', 'prix' => 30];
                    $typeBillets[1] = ['type' => 'Billet Grand Public -12 ans', 'prix' => 25];
                    $typeBillets[2] = ['type' => 'Billet Licenciés', 'prix' => round(30-30*0.17, 2)];
                    $typeBillets[3] = ['type' => 'Billet Journée de la Solidarité', 'prix' => round(30-30*0.3, 2)];
                } else if ($gradin == "Gradin Bas") {
                    $typeBillets[0] = ['type' => 'Billet Grand Public', 'prix' => 40];
                    $typeBillets[1] = ['type' => 'Billet Licenciés', 'prix' => round(40-40*0.17, 2)];
                    $typeBillets[2] = ['type' => 'Billet Journée de la Solidarité', 'prix' => round(40-40*0.3, 2)];
                } else if ($gradin == "Loge") {
                    $typeBillets[0] = ['type' => 'Billet Grand Public', 'prix' => 50];
                    $typeBillets[1] = ['type' => 'Billet Licenciés', 'prix' => round(50-50*0.17, 2)];
                    $typeBillets[2] = ['type' => 'Billet Journée de la Solidarité', 'prix' => round(50-50*0.3, 2)];
                }
                break;
            case 'Thursday':
                if($gradin == "Gradin Haut"){
                    $typeBillets[0] = ['type' => 'Billet Grand Public', 'prix' => 35];
                    $typeBillets[1] = ['type' => 'Billet Grand Public -12 ans', 'prix' => 30];
                    $typeBillets[2] = ['type' => 'Billet Licenciés', 'prix' => round(35-35*0.17, 2)];
                    $typeBillets[3] = ['type' => 'Billet Journée de la Solidarité', 'prix' => round(35-35*0.3, 2)];
                } else if ($gradin == "Gradin Bas") {
                    $typeBillets[0] = ['type' => 'Billet Grand Public', 'prix' => 40];
                    $typeBillets[1] = ['type' => 'Billet Licenciés', 'prix' => round(40-40*0.17, 2)];
                    $typeBillets[2] = ['type' => 'Billet Journée de la Solidarité', 'prix' => round(40-40*0.3, 2)];
                } else if ($gradin == "Loge") {
                    $typeBillets[0] = ['type' => 'Billet Grand Public', 'prix' => 50];
                    $typeBillets[1] = ['type' => 'Billet Licenciés', 'prix' => round(50-50*0.17, 2)];
                    $typeBillets[2] = ['type' => 'Billet Journée de la Solidarité', 'prix' => round(50-50*0.3, 2)];
                }
                break;
            case 'Friday':
                if($gradin == "Gradin Haut"){
                    $typeBillets[0] = ['type' => 'Billet Grand Public', 'prix' => 48];
                    $typeBillets[1] = ['type' => 'Billet Grand Public -12 ans', 'prix' => 38];
                    $typeBillets[2] = ['type' => 'Billet Licenciés', 'prix' => round(48-48*0.17, 2)];
                    $typeBillets[3] = ['type' => 'Billet Journée de la Solidarité', 'prix' => round(48-48*0.3, 2)];
                } else if ($gradin == "Gradin Bas") {
                    $typeBillets[0] = ['type' => 'Billet Grand Public', 'prix' => 60];
                    $typeBillets[1] = ['type' => 'Billet Licenciés', 'prix' => round(60-60*0.17, 2)];
                    $typeBillets[2] = ['type' => 'Billet Journée de la Solidarité', 'prix' => round(60-60*0.3, 2)];
                } else if ($gradin == "Loge") {
                    $typeBillets[0] = ['type' => 'Billet Grand Public', 'prix' => 70];
                    $typeBillets[1] = ['type' => 'Billet Licenciés', 'prix' => round(70-70*0.17, 2)];
                    $typeBillets[2] = ['type' => 'Billet Journée de la Solidarité', 'prix' => round(70-70*0.3, 2)];
                }
                break;
            case 'Saturday':
                if($gradin == "Gradin Haut"){
                    $typeBillets[0] = ['type' => 'Billet Grand Public', 'prix' => 48];
                    $typeBillets[1] = ['type' => 'Billet Grand Public -12 ans', 'prix' => 38];
                    $typeBillets[2] = ['type' => 'Billet Licenciés', 'prix' => round(48-48*0.17, 2)];
                    $typeBillets[3] = ['type' => 'Billet Journée de la Solidarité', 'prix' => round(48-48*0.3, 2)];
                } else if ($gradin == "Gradin Bas") {
                    $typeBillets[0] = ['type' => 'Billet Grand Public', 'prix' => 60];
                    $typeBillets[1] = ['type' => 'Billet Licenciés', 'prix' => round(60-60*0.17, 2)];
                    $typeBillets[2] = ['type' => 'Billet Journée de la Solidarité', 'prix' => round(60-60*0.3, 2)];
                } else if ($gradin == "Loge") {
                    $typeBillets[0] = ['type' => 'Billet Grand Public', 'prix' => 70];
                    $typeBillets[1] = ['type' => 'Billet Licenciés', 'prix' => round(70-70*0.17, 2)];
                    $typeBillets[2] = ['type' => 'Billet Journée de la Solidarité', 'prix' => round(70-70*0.3, 2)];
                }
                break;
            case 'Sunday':
                if($gradin == "Gradin Haut"){
                    $typeBillets[0] = ['type' => 'Billet Grand Public', 'prix' => 25];
                    $typeBillets[1] = ['type' => 'Billet Grand Public -12 ans', 'prix' => 20];
                    $typeBillets[2] = ['type' => 'Billet Licenciés', 'prix' => round(25-25*0.17, 2)];
                    $typeBillets[3] = ['type' => 'Billet Journée de la Solidarité', 'prix' => round(25-25*0.3, 2)];
                } else if ($gradin == "Gradin Bas") {
                    $typeBillets[0] = ['type' => 'Billet Grand Public', 'prix' => 30];
                    $typeBillets[1] = ['type' => 'Billet Licenciés', 'prix' => round(30-30*0.17, 2)];
                    $typeBillets[2] = ['type' => 'Billet Journée de la Solidarité', 'prix' => round(30-30*0.3, 2)];
                } else if ($gradin == "Loge") {
                    $typeBillets[0] = ['type' => 'Billet Grand Public', 'prix' => 40];
                    $typeBillets[1] = ['type' => 'Billet Licenciés', 'prix' => round(40-40*0.17, 2)];
                    $typeBillets[2] = ['type' => 'Billet Journée de la Solidarité', 'prix' => round(40-40*0.3, 2)];
                }
                break;
        }
        return $typeBillets;
    }
}
