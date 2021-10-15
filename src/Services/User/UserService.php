<?php

namespace App\Services\User;

use App\Repository\UserRepository;
use App\Services\Mail\MailService;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService {

    protected $hasher;
    protected $entityManager;
    protected $userRepository;
    protected $mailService;
    
    public function __construct(UserPasswordHasherInterface $hasher, EntityManagerInterface $entityManager, UserRepository $userRepository, MailService $mailService)
    {
        $this->hasher = $hasher;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->mailService = $mailService;
    }

    public function create($registerForm)
    {
        $user = $registerForm->getData();

        $searchMail = $this->userRepository->findOneBy(['email' => $user->getEmail()]);

        if(!$searchMail){
            $password = $this->hasher->hashPassword($user, $user->getPassword());
            $address = $registerForm['street']->getData().' '.$registerForm['city']->getData();
            $createdAt = new DateTimeImmutable();

            $user->setPassword($password);
            $user->setAddress($address);
            $user->setCreatedAt($createdAt);
            $user->setMailValidate(false);
            $user->setAccountValidate(false);
            $user->setLocation(0);
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->mailService->validationMail($user);

            return $succes = true;

        } else {
            
            return $succcess = 'error';
        }
    }

    public function newValidation($user, $code)
    {
        $validation = $user->getValidation();

        if($validation){
            $validation->setCode($code);
            $this->entityManager->flush();
            return true;
        }else{
            // $validation = new Validation;
            $validation -> setUser($user);
            $validation->setCode($code);
            $this->entityManager->persist($validation);
            $this->entityManager->flush();
            return true;
        }
        return false;
    }
}