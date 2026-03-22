<?php

namespace App\Controller;

use App\Entity\Actuality;
use App\Form\ActualityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ActualityController extends AbstractController
{

    // Only admin can create an actuality
    #[Route('/create-actuality', name: "campusActuality.create")]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request, EntityManagerInterface $em)
    {
        $actuality = new Actuality();
        $form = $this->createForm(ActualityType::class, $actuality);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($actuality);
                $em->flush();
                return $this->redirectToRoute("home");
            } else {

                // print an error when the form is submitted but not valid
                dd($form->getErrors(true, false));
            }
        }
        // if an error with the form is submitted, reload the same vue
        return $this->render('actuality/create.html.twig', ['form' => $form->createView()]);
    }


    // Only an admin can edit an actuality
    #[Route("/{id}/actuality-edit", name: "actuality.edit")]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Actuality $actuality, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(ActualityType::class, $actuality);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {


            if ($form->isValid()) {
                $em->flush();
                return $this->redirectToRoute("home");
            }
            // print an error when the form is submitted but not valid
            else {
                dd($form->getErrors(true, false));

            }
        }

        // if an error with the form is submitted, reload the same vue

        return $this->render("actuality/edit.html.twig", ["actuality" => $actuality, "form" => $form->createView()]);
    }


    // Only an admin can delete an actuality
    #[Route("/{id}/delete-actuality", name: "actuality.delete", methods: ["POST"])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Actuality $actuality, EntityManagerInterface $em)
    {
        $em->remove($actuality);
        $em->flush();
        // when deleted, redirect to home page
        return $this->redirectToRoute("home");
    }
}