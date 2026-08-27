<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(PhotoRepository $photoRepository): Response
    {
        $photos = $photoRepository->findBy([], ['position' => 'ASC'], 4);

        return $this->render('home/index.html.twig', [
            'photos' => $photos,
        ]);
    }

    #[Route('/portfolio', name: 'portfolio', methods: ['GET'])]
    public function portfolio(CategorieRepository $categorieRepository, PhotoRepository $photoRepository): Response
    {
        $categories = $categorieRepository->findBy([], ['position' => 'ASC']);

        $sections = array_map(
            static fn ($categorie) => [
                'categorie' => $categorie,
                'photos' => $photoRepository->findBy(['categorie' => $categorie], ['position' => 'ASC']),
            ],
            $categories,
        );

        return $this->render('home/portfolio.html.twig', [
            'sections' => $sections,
        ]);
    }
}
