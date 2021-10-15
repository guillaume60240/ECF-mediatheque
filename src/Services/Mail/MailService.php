<?php

namespace App\Services\Mail;

use App\Utils\Mail;
use App\Services\Validation\ValidationService;

class MailService
{
    protected $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function validationMail($user)
    {
        $mail = new Mail;
        $code = random_int(1000, 9999);
        $link = 'http://127.0.0.1:8000/valider-mon-mail';
        $name = $user->getName().' '.$user->getFirstname();

        $mail->sendValidation($user->getEmail(), $user->getName().' '.$user->getFirstname(), 'Validation de mail',$name, $code, $link);

        $this->validationService->newValidation($user, $code);
    }
}