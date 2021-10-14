<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/compte", name="account")
     */
    public function index(ReservationRepository $reservationRepository, BookRepository $bookRepository): Response
    {

        if($this->getUser()->getAccountValidate() === false){
            $this->addFlash('error', 'Votre compte n\'est pas encore validé.');
            return $this->redirectToRoute('app_login');
        }

        $reservations = $reservationRepository->findReservations($this->getUser()->getId());
        foreach($reservations as $reservation){
            $books[] = $bookRepository->findOneBy(['id' => $reservation->getBook()->getId()]);
        }

        $locations = $reservationRepository->findLocations($this->getUser()->getId());
        foreach($locations as $location){
            $books[] = $bookRepository->findOneBy(['id' => $location->getBook()->getId()]);
        }

        return $this->render('account/index.html.twig', [
            'reservations' => $reservations,
            'locations' => $locations,
            'books' => $books
        ]);
    }
}
