<?php

namespace App\Controller;

use App\Entity\Modules;
use App\Entity\School;
use App\Form\AddModuleType;
use App\Form\AddSchoolType;
use App\Repository\FormationRepository;
use App\Repository\ModulesRepository;
use App\Repository\SchoolRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModulesController extends AbstractController
{
    /**
     * @Route("/modules", name="modules")
     */
    public function index(ModulesRepository $repo): Response
    {
        $modules = $repo->findAll();
        return $this->render('modules/index.html.twig', [
            'modules' => $modules,
        ]);
    }

    /**
     * @Route("/modules{id}", name="module")
     */
    public function module(ModulesRepository $repo, $id): Response
    {
        $module = $repo->find($id);
        return $this->render('modules/individual_module.html.twig', [
            'module' => $module,
        ]);
    }

    /**
     * @Route("/addModule", name="addModule")
     */
    public function addModule(Request $request, EntityManagerInterface $manager): Response
    {
        $module = new Modules();

        $new_module_form = $this->createForm(AddModuleType::class, $module)->handleRequest($request);

        if ($new_module_form->isSubmitted()){
            $module = $new_module_form->getData();

            $manager->persist($module);

            $manager->flush();

            return $this->redirectToRoute('module', [
                'id' => $module->getId()
            ]);
        }

        return $this->render('modules/add_module.html.twig', [
            'new_module_form' => $new_module_form->createView(),
        ]);
    }

    /**
     * @Route("/updateModule/{id}", name="updateModule")
     */
    public function updateSchool(Request $request, EntityManagerInterface $manager, $id): Response
    {
        $module = $manager->getRepository(Modules::class)->find($id);

        $new_module_form = $this->createForm(AddModuleType::class, $module);

        $new_module_form->handleRequest($request);

        if ($new_module_form->isSubmitted()) {
            $module = $new_module_form->getData();

            $manager->persist($module);

            $manager->flush();

            return $this->redirectToRoute('module', [
                'id' => $id,
            ]);
        }

        return $this->render('modules/add_module.html.twig', [
            'new_module_form' => $new_module_form->createView(),
        ]);
    }

    /**
     * @Route("/deleteModule/{id}", name="deleteModule")
     */
    public function delete($id, EntityManagerInterface $manager, ModulesRepository $repo){
        $module = $repo->find($id);

        $manager->remove($module);
        $manager->flush();

        return $this->redirectToRoute('admin');
    }
}
