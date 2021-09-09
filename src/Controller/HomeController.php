<?php

namespace App\Controller;

use App\Repository\FormationRepository;
use App\Repository\ModulesRepository;
use App\Repository\SchoolRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(EntityManagerInterface $manager, SchoolRepository $schoolsRepo, FormationRepository $formationsRepo, ModulesRepository $modulesRepo): Response
    {
        $schools = $schoolsRepo->findBy([],[], 3, 0);

        $formations = $formationsRepo->findBy([],[], 3, 0);

        $modules = $modulesRepo->findBy([],[], 3, 0);

        return $this->render('home/index.html.twig', [
            'schools'       => $schools,
            'formations'    => $formations,
            'modules'       =>$modules,
        ]);
    }
}
