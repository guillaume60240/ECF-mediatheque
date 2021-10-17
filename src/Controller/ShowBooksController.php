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
     * @Route("/membre/catalogue/?page={pageBook}", name="show_books")
     */
    public function index(BookRepository $bookRepository, int $pageBook = 1): Response
    {
        //variables de pagination
        $limit = 6;
        
        $books = $bookRepository->getPaginatedBooks($pageBook, $limit);
        $totalBooks = count($bookRepository->findAll());
        //redirection si une page inexistante est demandée
        if($pageBook > ceil($totalBooks/$limit) && $pageBook != 1){
            return $this->redirectToRoute('show_books', ['pageBook' => 1]);
        }

        return $this->render('show_books/index.html.twig', [
            'books' => $books,
            'totalBooks' => $totalBooks,
            'pageBook' => $pageBook,
            'limit' => $limit
        ]);
    }

    /**
     * @Route("/membre/catalogue-categorie/{category}/?page={pageBook}", name="show_books_category")
     */
    public function showByCategory(BookRepository $bookRepository, CategoryRepository $categoryRepository, string $category, $pageBook = 1): Response
    {
        $bookCategory = $categoryRepository->findOneBy(['id' => $category]);
        
        if($bookCategory){
            $limit = 6;
            $books = $bookRepository->getPaginatedBooksByCategory($pageBook, $limit, $category);
            
            if($books){
                $totalBooks = count($bookRepository->findBy(['category' => $category]));
                //redirection si une page inexistante est demandée
                if($pageBook > ceil($totalBooks/$limit) && $pageBook != 1){
                return $this->redirectToRoute('show_books_category', ['category' => $category, 'pageBook' => 1]);
                }
                return $this->render('show_books/index.html.twig', [
                    'books' => $books,
                    'totalBooks' => $totalBooks,
                    'pageBook' => $pageBook,
                    'limit' => $limit,
                    'category' => $category
                ]);
            } else{
                $this->addFlash('error', 'Il n\'y a pas de livre dans cette catégorie.');
                return $this->redirectToRoute('show_books');
            }
        } else{
            $this->addFlash('error', 'Cette catégorie n\'existe pas');
            return $this->redirectToRoute('show_books');
        }
    }

    /**
     * @Route("/membre/catalogue-auteur/{autorSlug}/?page={pageBook}", name="show_books_autor")
     */
    public function showByAutor(BookRepository $bookRepository, string $autorSlug, $pageBook = 1): Response
    {
        $limit = 6;

        $books = $bookRepository->getPaginatedBooksByAutor($pageBook, $limit, $autorSlug);

         if($books){
            $totalBooks = count($bookRepository->findBy(['autorSlug' => $autorSlug]));
            //redirection si une page inexistante est demandée
            if($pageBook > ceil($totalBooks/$limit) && $pageBook != 1){
            return $this->redirectToRoute('show_books_category', ['autorSlug' => $autorSlug, 'pageBook' => 1]);
            }
            return $this->render('show_books/index.html.twig', [
                'books' => $books,
                'totalBooks' => $totalBooks,
                'pageBook' => $pageBook,
                'limit' => $limit,
                'autorSlug' => $autorSlug
            ]);
         } else{
            $this->addFlash('error', 'Cet auteur n\'existe pas');
            return $this->redirectToRoute('show_books');
         }
    }
}
