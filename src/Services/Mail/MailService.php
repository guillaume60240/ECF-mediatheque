<?php

namespace App\Services\Mail;

use App\Utils\Mail;
use App\Services\User\UserService;

class MailService
{
    protected $userService;

    // public function __construct(UserService $userService)
    // {
    //     $this->userService = $userService;
    // }

    public function validationMail($user)
    {
        $mail = new Mail;
        $code = random_int(1000, 9999);
        $link = 'http://127.0.0.1:8000/valider-mon-mail';

        $mail->sendValidation($user->getEmail(), $user->getName().' '.$user->getFirstname(), 'Validation de mail', $code, $link);

        // $this->userService->newValidation($user, $code);
    }
}