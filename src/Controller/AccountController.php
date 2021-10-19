<?php

namespace App\Controller;

use App\Form\ValidationMailType;
use App\Repository\BookRepository;
use App\Repository\ReservationRepository;
use App\Services\Validation\ValidationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/compte", name="account")
     */
    public function index(ReservationRepository $reservationRepository, BookRepository $bookRepository): Response
    {
        $books = [];
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

    /**
     * @Route("/valider-mon-mail", name="accountValidate")
     */
    public function validate(Request $request, ValidationService $validationService): Response
    {
        $form = $this->createForm(ValidationMailType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $mail = $form->get('user')->getData();
            $code = $form->get('code')->getData();
            $action = $validationService->valideMail($mail, $code);

            if($action === true){
                $this->addFlash('success', 'Votre mail a été validé. Vous recevrez un mail quand votre compte aura été validé.');
                return $this->redirectToRoute('app_login');
               
            }else{
                $this->addFlash('error', 'Il y a eu une erreur dans la validation de votre mail.');
            }
        }
        
        return $this->render('account/validate.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
