<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\BookOrder;
use App\Entity\BookOrderProduct;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $bookRepository = $doctrine->getRepository(Book::class);
        return $this->render('book/index.html.twig', [
            'user' => $this->getUser(),
            'book' => $bookRepository->find($request->query->get('book_id')),
        ]);
    }

    #[Route('/book/addBookOrder/', name: 'app_book_cart')]
    public function addBookOrder(Request $request, ManagerRegistry $doctrine): Response
    {
        $bookRepository = $doctrine->getRepository(Book::class);
        $bookOrderRepository = $doctrine->getRepository(BookOrder::class);
        $bookOrderProductRepository = $doctrine->getRepository(BookOrderProduct::class);
        $book = $bookRepository->find($request->query->get('book_id'));
        $user = $this->getUser();

        $bookOrder = $bookOrderRepository->findOneBy([
            'user' => $user,
            'status' => 0
        ]);
        if ($bookOrder == null) {
            $bookOrder = new BookOrder();
            $bookOrder->setStatus(0);
            $bookOrder->setDate(date_create());
            $bookOrder->setUser($this->getUser());
        }

        $bookOrderProduct = $bookOrderProductRepository->findOneBy([
            'book' => $book,
            'bookOrder' => $bookOrder,
        ]);
        if ($bookOrderProduct == null) {
            $bookOrderProduct = new BookOrderProduct();
            $bookOrderProduct->setBookOrder($bookOrder);
            $bookOrderProduct->setBook($book);
            $bookOrderProduct->setCost($book->getCost());
            $bookOrderProduct->setCount(1);
        } else {
            $bookOrderProduct->setCount($bookOrderProduct->getCount() + 1);
        }

        $bookOrder->getBookOrderProducts()->add($bookOrderProduct);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($bookOrder);
        $entityManager->persist($bookOrderProduct);
        $entityManager->flush();

        return $this->render('book/index.html.twig', [
            'book' => $book,
            'user' => $user,
        ]);
    }
}
