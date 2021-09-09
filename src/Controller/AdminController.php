<?php

namespace App\Controller;

use App\Repository\FormationRepository;
use App\Repository\ModulesRepository;
use App\Repository\SchoolRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(SchoolRepository $schoolRepo, FormationRepository $formationRepo, ModulesRepository $moduleRepo): Response
    {
        $schools = $schoolRepo->findAll();
        $formations = $formationRepo->findAll();
        $modules = $moduleRepo->findAll();
        return $this->render('admin/index.html.twig', [
            'schools' => $schools,
            'formations' => $formations,
            'modules' => $modules,
        ]);
    }
}
