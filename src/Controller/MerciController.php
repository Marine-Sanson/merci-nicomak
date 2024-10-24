<?php

namespace App\Controller;

use DateTimeZone;
use App\Entity\Merci;
use DateTimeImmutable;
use App\Form\MerciType;
use App\Service\MerciService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MerciController extends AbstractController
{
    public function __construct(
        private readonly MerciService $merciService,
    ) {

    }

    #[Route('/remercier', name: 'app_add_merci')]
    public function index(Request $request): Response
    {
        $merci = new Merci();

        $merciForm = $this->createForm(MerciType::class, $merci);
        $merciForm->handleRequest($request);

        if ($merciForm->isSubmitted() && $merciForm->isValid()) {

            $merci
                ->setAuthor($this->getUser())
                ->setCreatedAt(new DateTimeImmutable("now", new DateTimeZone("Europe/Paris")));
                ;
            
            $this->merciService->saveMerci($merci);
            
            $this->addFlash('success', 'Votre remerciement a bien été pris en compte');
            return $this->redirectToRoute('app_home');

        }

        return $this->render('merci/merci.html.twig', [
            'merciForm' => $merciForm,
        ]);
    }

    #[Route('/gerer-mes-mercis', name: 'app_manage_mercis')]
    public function manageMercis(Request $request): Response
    {
        $mercis = $this->merciService->findAllMyMercis($this->getUser());
        return $this->render('merci/manage-mercis.html.twig', [
            'mercis' => $mercis,
        ]);
    }

    #[Route('/modifier-merci/{id}', name: 'app_update_merci')]
    public function updateMerci(Request $request, int $id): Response
    {
        $merci = $this->merciService->findOneById($id);
        $merciForm = $this->createForm(MerciType::class, $merci);
        $merciForm->handleRequest($request);

        if ($merciForm->isSubmitted() && $merciForm->isValid()) {

            $this->merciService->saveMerci($merci);
            
            $this->addFlash('success', 'Votre remerciement a bien été modifié');
            return $this->redirectToRoute('app_manage_mercis');

        }

        return $this->render('merci/update-merci.html.twig', [
            'merciForm' => $merciForm,
        ]);
    }

    #[Route('/supprimer-merci/{id}', name: 'app_delete_merci')]
    public function deleteMerci(Request $request, int $id): Response
    {
        $merci = $this->merciService->findOneById($id);

        return $this->render('merci/delete-merci.html.twig', [
            'merci' => $merci,
        ]);
    }

    #[Route('/suppression-merci/{id}', name: 'app_confirm_delete_merci')]
    public function confirmDeleteMerci(Request $request, int $id): Response
    {
        $existingMerci = $this->merciService->deleteMerciIfExist($id);
        if (!$existingMerci)
        {
            $this->addFlash('danger', 'Il y a eu un problème, veuillez recommencer');
            return $this->redirectToRoute('app_manage_mercis');
        }

        $mercis = $this->merciService->findAllMyMercis($this->getUser());

        return $this->render('merci/manage-mercis.html.twig', [
            'mercis' => $mercis,
        ]);
    }


}
