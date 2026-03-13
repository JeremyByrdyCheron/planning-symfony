<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\PlanningType;
use App\Repository\CoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class PlanningController extends AbstractController
{
    #[Route('/planning', name: 'planning.index')]
    public function index(Request $request): Response
    {
        return new Response('Planning: ');
    }

    #[Route('/planning/{id}', name: 'planning.show')]
    public function show(int $id, CoursRepository $coursRepository): Response
    {
        $cours = $coursRepository->find($id);

        if (!$cours) {
            throw $this->createNotFoundException('Cours non trouvé.');
        }

        return $this->render('planning/show.html.twig', [
            'cours' => $cours
        ]);
    }

    #[Route("/{id}/edit", name: "planning.edit")]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Cours $cours, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(PlanningType::class, $cours);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute("home");
        }


        return $this->render("planning/edit.html.twig", ["cours" => $cours, "form" => $form->createView()]);
    }

    #[Route('/create', name: "planning.create")]
    #[IsGranted('ROLE_ADMIN')]

    public function create(Request $request, EntityManagerInterface $em)
    {
        $cours = new Cours();
        $form = $this->createForm(PlanningType::class, $cours);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($cours);
                $em->flush();
                return $this->redirectToRoute("home");
            } else {
                dd($form->getErrors(true, false));
            }
        }
        return $this->render('planning/create.html.twig', ['form' => $form->createView()]);
    }

}
