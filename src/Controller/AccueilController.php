<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;




class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',

        ]);
    }

    /**
     * @Route("/vider_panier", name="accueil_vider_panier")
     */
    public function viderPanier(ManagerRegistry $doctrine, Request $request)
    {
        $em = $doctrine->getManager()->getConnection();
        // prepare statement
        $userId = $this->getUser()->getId();
        $sth = $em->prepare("call valider_paiement($userId)");
        $sth->execute();

        return $this->redirectToRoute('accueil', [], Response::HTTP_SEE_OTHER);
    }
}
