<?php

namespace App\Services\Location;

use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class LocationService {

    protected $entityManager;
    protected $reservationRepository;

    public function __construct(EntityManagerInterface $entityManager, ReservationRepository $reservationRepository)
    {
        $this->entityManager = $entityManager;
        $this->reservationRepository = $reservationRepository;
    }

    public function new($user, $book)
    {
        $userLocation = $user->getLocation();

        if($userLocation < 10 && $book->getAvailable() === true){

            $location = new Reservation;
            
            $location->setUser($user);
            $location->setBook($book);
            $createdAt = new DateTimeImmutable();
            $location->setCreatedAt($createdAt);
            $location->setValidate(false);
            $location->setRestitution(false);
            
            $user->setLocation($userLocation + 1);
            $book->setAvailable(false);

            $this->entityManager->persist($location);
            $this->entityManager->flush();

            return true;
        }
    }

    public function delete($reservation)
    {
        $reservation->getBook()->setAvailable(true);
        $location = $reservation->getUser()->getLocation();
        $reservation->getUser()->setLocation($location - 1);
        
        $this->entityManager->remove($reservation);

        $this->entityManager->flush();
    }

    public function removeNonValidateReservation()
    {
        $reservations = $this->reservationRepository->getNonValidateReservations();
        if($reservations){
            $now = new DateTimeImmutable();
            $deleted = 0;
            foreach($reservations as $reservation){
                if($reservation->getCreatedAt() < $now->modify('- 3 day') ){
                    $this->delete($reservation);
                    $deleted ++;
                }
            }

            return $deleted;
        }
    }
}