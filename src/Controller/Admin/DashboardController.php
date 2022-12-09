<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TournoiRepository;
use App\Entity\User;
use App\Entity\Equipe;
use App\Entity\Joueur;
use App\Entity\Tournoi;
use App\Entity\Arbitre;
use App\Entity\Ramasseur;
use App\Entity\Court;
use App\Entity\Rencontre;
use App\Entity\Journee;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);
                $url = $routeBuilder->setController(ArbitreCrudController::class)->generateUrl();
        
               return $this->redirect($url);
    }

    /**
     * @Route("/admin/{tournoi_id}", name="admin_generation_tournoi")
     */
    public function generationTournoi(ManagerRegistry $doctrine, int $tournoi_id, TournoiRepository $tournoiRepo): Response
    {
        $entityManager = $doctrine->getManager();

        $tournoi = $tournoiRepo->find($tournoi_id);

        if(is_null($tournoi)){
            return new Response('Tournoi non trouvé.');
        }
        

        $equipes = $tournoi->getEquipes();
        $nb_equipes = $equipes->count();
        if (is_null($nb_equipes) || $nb_equipes % 2 != 0 || $nb_equipes < 4){
            return new Response('Nombre impair ou pas assez d équipe pour générer le tournoi.');
        }

        $i = 0;
        $temp = array();
        while ($i < ($nb_equipes/4)) {   
            
            $temp2 = array();

            $i = $i + 1;
        }

        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(1999);
        $product->setDescription('Ergonomic and stylish!');
        $entityManager->persist($product);


        $entityManager->flush();

        return new Response('Tournoi généré -> id '.$product->getId(). '.');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Open Parc');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Back to the website', 'fas fa-home', 'accueil');
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Equipes', 'fas fa-users', Equipe::class);
        yield MenuItem::linkToCrud('Joueurs', 'fas fa-table-tennis', Joueur::class);
        yield MenuItem::linkToCrud('Arbitres', 'fas fa-flag', Arbitre::class);
        yield MenuItem::linkToCrud('Ramasseurs', 'fas fa-genderless', Ramasseur::class);
        yield MenuItem::linkToCrud('Courts', 'fas fa-map-marker-alt', Court::class);
        yield MenuItem::linkToCrud('Tournois', 'fas fa-trophy', Tournoi::class);
        yield MenuItem::linkToCrud('Rencontres', 'fas fa-bullhorn', Rencontre::class);
        yield MenuItem::linkToCrud('Journées', 'fas fa-calendar-week', Journee::class);
    }
}
