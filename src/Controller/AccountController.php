<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/compte", name="account")
     */
    public function index(): Response
    {

        if($this->getUser()->getAccountValidate() === false){
            $this->addFlash('error', 'Votre compte n\'est pas encore validé.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }
}
