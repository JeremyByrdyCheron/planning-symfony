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

final class HomeControlleController extends AbstractController
{
    #[Route("/", name: "home")]
    function index(CoursRepository $cours): Response
    {
        $plannings = $cours->findAll();
        return $this->render("planning/index.html.twig", ["plannings" => $plannings]);
    }


}
