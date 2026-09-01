<?php

namespace App\Controller;

use App\Repository\AssuranceRepository;
use App\Repository\PersonneRepository;
use App\Repository\VoitureRepository;
use App\Service\AssuranceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        PersonneRepository $personneRepository,
        VoitureRepository $voitureRepository,
        AssuranceRepository $assuranceRepository,
        AssuranceService $assuranceService,
    ): Response {
        return $this->render('home/index.html.twig', [
            'nb_personnes' => count($personneRepository->findAll()),
            'nb_voitures' => count($voitureRepository->findAll()),
            'nb_assurances' => count($assuranceRepository->findAll()),
            'assurances_expirant_bientot' => $assuranceService->assurancesExpirantBientot(30),
        ]);
    }
}
