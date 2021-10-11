<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowBooksController extends AbstractController
{
    /**
     * @Route("/membre/catalogue", name="show_books")
     */
    public function index(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();

        return $this->render('show_books/index.html.twig', [
            'controller_name' => 'ShowBooksController',
            'books' => $books
        ]);
    }
}
