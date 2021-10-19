<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\ReservationRepository;
use App\Services\Location\LocationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    /**
     * @Route("/membre/reservation/{id}", name="reservation")
     */
    public function index(BookRepository $bookRepository, LocationService $locationService, Request $request, $id): Response
    {
        $book = $bookRepository->findOneBy(['id' => $id]);

        if(!$book){
            return $this->redirectToRoute('show_books');
        }

        $location = $locationService->new($this->getUser(), $book);

        if($location){
            $this->addFlash(
                'success',
                'Vous avez réservé le livre '.$book->getTitle().' de '.$book->getAuthor()
            );
        } else {
            $this->addFlash(
                'error',
                'Le livre '.$book->getTitle().' de '.$book->getAuthor().' n\'est pas disponible pour le moment '
            );
        }

        return $this->redirect($request->server->get('HTTP_REFERER'));
    }

    /**
     * @route("/membre/annulation/{id}", name="deleteReservation")
     */
    public function delete(ReservationRepository $reservationRepository,LocationService $locationService, Request $request, $id)
    {
        $reservation = $reservationRepository->findOneBy(['id' => $id]);

        if($reservation){

            $book = $reservation->getBook();
            $locationService->delete($reservation);
            $this->addFlash(
                'success',
                'Vous avez annulé la réservation de '.$book->getTitle().' de '.$book->getAuthor()
            );
        }

        return $this->redirect($request->server->get('HTTP_REFERER'));
    }
}
