<?php

namespace App\Controller;
use App\Entity\Anecdote;
use App\Form\AnecdoteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class AnecdoteController extends AbstractController
{
    #[Route('/create-anecdote', name: "anecdote.create")]
    #[IsGranted('ROLE_ADMIN')]

    public function create(Request $request, EntityManagerInterface $em)
    {
        $anecdote = new Anecdote();
        $form = $this->createForm(AnecdoteType::class, $anecdote);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($anecdote);
                $em->flush();
                return $this->redirectToRoute("home");
            } else {
                dd($form->getErrors(true, false));
            }
        }
        return $this->render('anecdote/create.html.twig', ['form' => $form->createView()]);
    }
    #[Route("/{id}/anecdote-edit", name: "anecdote.edit")]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Anecdote $anecdote, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(AnecdoteType::class, $anecdote);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute("home");
        }


        return $this->render("anecdote/edit.html.twig", ["anecdote" => $anecdote, "form" => $form->createView()]);
    }
    #[Route("/{id}/delete-anecdote", name: "anecdote.delete", methods: ["POST"])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Anecdote $anecdote, EntityManagerInterface $em)
    {
        $em->remove($anecdote);
        $em->flush();

        return $this->redirectToRoute("home");
    }
}
