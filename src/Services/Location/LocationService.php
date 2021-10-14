<?php

namespace App\Services\Location;

use App\Entity\Reservation;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class LocationService {

    protected $userRepo;
    protected $bookRepo;
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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

        }
    }
}