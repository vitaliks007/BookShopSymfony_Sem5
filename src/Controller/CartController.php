<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\BookOrder;
use App\Entity\BookOrderProduct;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $bookOrderRepository = $doctrine->getRepository(BookOrder::class);
        $bookOrderProductRepository = $doctrine->getRepository(BookOrderProduct::class);
        $user = $this->getUser();
        $bookOrder = $bookOrderRepository->findOneBy([
            'user' => $user,
            'status' => 0
        ]);

        $bookOrderProducts = $bookOrderProductRepository->findBy([
            'bookOrder' => $bookOrder
        ]);

        $bookOrderProductsCount = count($bookOrderProducts);
        $bookOrderProductsSum = 0;

        foreach ($bookOrderProducts as $bookOrderProduct)
        {
            $bookOrderProductsSum += $bookOrderProduct->getCost();
        }

        return $this->render('cart/index.html.twig', [
            'user' => $user,
            'bookOrderProducts' => $bookOrderProducts,
            'bookOrderProductsCount' => $bookOrderProductsCount,
            'bookOrderProductsSum' => $bookOrderProductsSum
        ]);
    }

    #[Route('/cart/delete', name: 'app_cart_delete')]
    public function deleteBookOrderProduct(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $bookOrderProductRepository = $doctrine->getRepository(BookOrderProduct::class);
        $bookOrderProduct = $bookOrderProductRepository->findOneBy([
            'id' => $request->query->get('bookOrderProductId')
        ]);
        $entityManager->remove($bookOrderProduct);
        $entityManager->flush();
        return $this->index($doctrine);
    }

    #[Route('/cart/sell', name: 'app_cart_sell')]
    public function sellBookOrder(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $bookOrderRepository = $doctrine->getRepository(BookOrder::class);
        $bookOrderProductRepository = $doctrine->getRepository(BookOrderProduct::class);

        $bookOrder = $bookOrderRepository->findOneBy([
            'id' => $request->query->get('bookOrderId')
        ]);
        $bookOrderProducts = $bookOrderProductRepository->findBy([
            'bookOrder' => $bookOrder
        ]);

        $bookOrder->setStatus(1);
        foreach ($bookOrderProducts as $bookOrderProduct)
        {
            $book = $bookOrderProduct->getBook();
            $book->setCount($book->getCount() - $bookOrderProduct->getCount());
            $entityManager->persist($book);
        }

        $entityManager->flush();
        return $this->index($doctrine);
    }
}
