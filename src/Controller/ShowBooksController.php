<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
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

    /**
     * @Route("/membre/catalogue/{category}", name="show_books_category")
     */
    public function showByCategory(CategoryRepository $categoryRepository, string $category): Response
    {
        $bookCategory = $categoryRepository->findOneBy(['id' => $category]);
        
        if($bookCategory){
            $books = $bookCategory->getBooks();
            
            if($books){
                
                return $this->render('show_books/index.html.twig', [
                    'books' => $books
                ]);
            } else{
                $this->addFlash('error', 'Il n\'y a pas de livre dans cette catégorie.');
                return $this->redirectToRoute('show_books');
            }
        } else{
            $this->addFlash('error', 'Catte catégorie n\'existe pas');
            return $this->redirectToRoute('show_books');
        }
    }
}
