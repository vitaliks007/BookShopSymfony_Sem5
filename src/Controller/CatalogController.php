<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    #[Route('/catalog', name: 'app_catalog')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $bookRepository = $doctrine->getRepository(Book::class);

        return $this->render('catalog/index.html.twig', [
            'controller_name' => 'CatalogController',
            'user' => $this->getUser(),
            'books' => $bookRepository->findAll()
        ]);
    }
}
