<?php

namespace App\Utils;

use Mailjet\Client;
use Mailjet\Resources;

class Mail{
    private $api_key = '7db1903fc486fa9e3409135d0c98a699';
    private $api_key_secrete = '93d9763ffd47b2727f7041758d0920b9';

    public function sendValidation($to_email, $to_name, $subject, $name, $code, $link, $template){
        $mj= new Client($this->api_key, $this->api_key_secrete,true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "guillaume.lepoetre@gmail.com",
                        'Name' => "Médiathèque de La Chapelle-Curreaux"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => $template,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'name' => $name,
                        'code' => $code,
                        'link' => $link
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }

    public function sendWelcome($to_email, $to_name, $subject, $name, $template)
    {
        $mj= new Client($this->api_key, $this->api_key_secrete,true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "guillaume.lepoetre@gmail.com",
                        'Name' => "Médiathèque de La Chapelle-Curreaux"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => $template,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'name' => $name,
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}