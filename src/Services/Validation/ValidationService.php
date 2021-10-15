<?php

namespace App\Services\Validation;

use App\Entity\Validation;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class ValidationService
{
    protected $entityManager;
    protected $userRepository;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    public function newValidation($user, $code)
    {
        $validation = new Validation;
        $validation -> setUser($user);
        $validation->setCode($code);
        $this->entityManager->persist($validation);
        $this->entityManager->flush();
        
    }

    public function valideMail($mail, $code)
    {
       $user =  $this->userRepository->findOneBy(['email' => $mail]);
       if($user){

            $validation = $user->getValidation();

            if($validation){

                $userCode = $validation->getCode();
                
                if($userCode === $code){
                    $user->setMailValidate(true);
                    $this->entityManager->remove($validation);
                    $this->entityManager->flush();
                    
                    return true;
                } else{
                    return false;
                }
            }
        } else{
            return false;
        }
    }
}