<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $user = new User();
        $registerForm = $this->createForm(RegisterType::class, $user);

        return $this->render('home/index.html.twig',[
            'registerForm' => $registerForm->createView()
        ]);
    }
}
