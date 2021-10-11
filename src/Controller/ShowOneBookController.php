<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowOneBookController extends AbstractController
{
    /**
     * @Route("/membre/livre/{bookTitleSlug}", name="show_one_book")
     */
    public function index(BookRepository $bookRepository,string $bookTitleSlug): Response
    {
        $book = $bookRepository->findOneBy(['titleSlug' => $bookTitleSlug]);

        return $this->render('show_books/one.html.twig', [
            'controller_name' => 'ShowOneBookController',
            'book' => $book
        ]);
    }
}
