<?php

namespace App\Controller;

use App\Service\MerciService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly MerciService $merciService,
    ) {

    }


    #[Route('', name: 'app_home')]
    public function index(): Response
    {
        $mercis = $this->merciService->findAllMercis();
        return $this->render('home/home.html.twig', [
            'mercis' => $mercis,
        ]);
    }
}
