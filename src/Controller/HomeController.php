<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Services\User\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, UserService $userService): Response
    {
        $success = false;
        $user = new User();
        $registerForm = $this->createForm(RegisterType::class, $user);
        $registerForm->handleRequest($request);
        if($registerForm->isSubmitted() && $registerForm->isValid()){

            $success = $userService->create($registerForm);

            if($success === true) {
                $this->addFlash('success', 'Inscription réussie, merci de rentrer le code reçu par mail.');
                return $this->redirectToRoute('accountValidate');
            } elseif($success === 'error') {
                $this->addFlash('error', 'Une erreur s\'est produite, merci de réessayer plus tard.');
            }
            
        };

        return $this->render('home/index.html.twig',[
            'registerForm' => $registerForm->createView()
        ]);
    }
}
