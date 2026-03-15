<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\PlanningType;
use App\Repository\CoursRepository;
use App\Repository\AnecdoteRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use DOMDocument;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeControlleController extends AbstractController
{
    #[Route("/", name: "home")]
    function index(CoursRepository $cours, AnecdoteRepository $anecdote): Response
    {
        $anecdotes = $anecdote->findAll();
        $today = new \DateTime();
        $todayPlanning = $cours->findBy([
            'date' => $today
        ]);

        $tomorrow = new DateTime("tomorrow");
        $tomorrowPlanning = $cours->findBy([
            'date' => $tomorrow
        ]);
        $compiegneActuality = simplexml_load_file("https://www.agglo-compiegne.fr/rss/actualites");

        // $plannings = $cours->findAll();
        return $this->render("planning/index.html.twig", ["todayPlanning" => $todayPlanning, "tomorrowPlanning" => $tomorrowPlanning, "anecdotes" => $anecdotes, "xml" => $compiegneActuality]);
    }


}
