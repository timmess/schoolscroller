<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\School;
use App\Form\AddFormationType;
use App\Form\AddSchoolType;
use App\Repository\FormationRepository;
use App\Repository\SchoolRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationController extends AbstractController
{
    /**
     * @Route("/formation", name="formations")
     */
    public function index(FormationRepository $repo): Response
    {
        $formations = $repo->findAll();
        return $this->render('formation/index.html.twig', [
            'formations' => $formations,
        ]);
    }

    /**
     * @Route("/formation/{id}", name="formation")
     */
    public function formation($id, FormationRepository $repo): Response
    {
        $formation = $repo->find($id);
        return $this->render('formation/individual_formation.html.twig', [
            'formation' => $formation,
        ]);
    }

    /**
     * @Route("/addFormation", name="addFormation")
     */
    public function addFormation(Request $request, EntityManagerInterface $manager): Response
    {
        $formation = new Formation();

        $new_formation_form = $this->createForm(AddFormationType::class, $formation)->handleRequest($request);

        if ($new_formation_form->isSubmitted()){
            $formation = $new_formation_form->getData();

            $manager->persist($formation);

            $manager->flush();

            return $this->redirectToRoute('formation', [
                'id' => $formation->getId()
            ]);
        }

        return $this->render('formation/add_formation.html.twig', [
            'new_formation_form' => $new_formation_form->createView(),
        ]);
    }

    /**
     * @Route("/updateFormation/{id}", name="updateFormation")
     */
    public function updateFormation(Request $request, EntityManagerInterface $manager, $id): Response
    {
        $formation = $manager->getRepository(Formation::class)->find($id);

        $new_formation_form = $this->createForm(AddFormationType::class, $formation);

        $new_formation_form->handleRequest($request);

        if ($new_formation_form->isSubmitted()) {
            $formation = $new_formation_form->getData();

            $manager->persist($formation);

            $manager->flush();

            return $this->redirectToRoute('formation', [
                'id' => $id,
            ]);
        }

        return $this->render('formation/add_formation.html.twig', [
            'new_formation_form' => $new_formation_form->createView(),
        ]);
    }

    /**
     * @Route("/deleteFormation/{id}", name="deleteFormation")
     */
    public function delete($id, EntityManagerInterface $manager, FormationRepository $repo){
        $formation = $repo->find($id);

        $manager->remove($formation);
        $manager->flush();

        return $this->redirectToRoute('admin');
    }
}
