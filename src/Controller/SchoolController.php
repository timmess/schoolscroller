<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Entity\School;
use App\Form\AddClientType;
use App\Form\AddSchoolType;
use App\Repository\SchoolRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Config\Doctrine\Orm\EntityManagerConfig;

class SchoolController extends AbstractController
{
    /**
     * @Route("/school", name="schools")
     */
    public function index(SchoolRepository $repo): Response
    {
        $schools = $repo->findAll();
        return $this->render('school/index.html.twig', [
            'schools' => $schools
        ]);
    }

    /**
     * @Route("/school/{id}", name="school")
     */
    public function school($id,  SchoolRepository $repo): Response
    {
        $school = $repo->find($id);
        return $this->render('school/individual_school.html.twig', [
            'school' => $school,
        ]);
    }

    /**
     * @Route("/addSchool", name="addSchool")
     */
    public function addSchool(Request $request, EntityManagerInterface $manager): Response
    {
        $school = new School();

        $new_school_form = $this->createForm(AddSchoolType::class, $school)->handleRequest($request);

        if ($new_school_form->isSubmitted()){
            $school = $new_school_form->getData();

            $formations = $school->getFormations();

            foreach ($formations as $formation){
                $school->addFormation($formation);
            }

            $manager->persist($school);

            $manager->flush();

            return $this->redirectToRoute('school', [
                'id' => $school->getId()
            ]);
        }

        return $this->render('school/add_school.html.twig', [
            'new_school_form' => $new_school_form->createView(),
        ]);
    }

    /**
     * @Route("/updateSchool/{id}", name="updateSchool")
     */
    public function updateSchool(Request $request, EntityManagerInterface $manager, $id): Response
    {
        $school = $manager->getRepository(School::class)->find($id);

        $new_school_form = $this->createForm(AddSchoolType::class, $school);

        $new_school_form->handleRequest($request);

        if ($new_school_form->isSubmitted()) {
            $school = $new_school_form->getData();

            $manager->persist($school);

            $manager->flush();

            return $this->redirectToRoute('school', [
                'id' => $id,
            ]);
        }

        return $this->render('school/add_school.html.twig', [
            'new_school_form' => $new_school_form->createView(),
        ]);
    }

    /**
     * @Route("/deleteSchool/{id}", name="deleteSchool")
     */
    public function delete($id, EntityManagerInterface $manager, SchoolRepository $repo){
        $school = $repo->find($id);

        $manager->remove($school);
        $manager->flush();

        return $this->redirectToRoute('admin');
    }
}
