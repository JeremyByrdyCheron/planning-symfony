<?php

namespace App\Controller;
use App\Entity\Anecdote;
use App\Form\AnecdoteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
}
