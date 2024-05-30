<?php
namespace App\Forms;

class AddUser
{
    public static function getConfig(): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Envoyer un mail de création de mot de passe"
                ],
            "inputs"=>[
                "lastname"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Votre nom",
                    "required"=>true,
                    "error"=>"Votre nom doit faire entre 2 et 50 caractères"
                ],
                "firstname"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Votre prénom",
                    "required"=>true,
                    "error"=>"Votre prénom doit faire entre 2 et 50 caractères"
                ],
                "email"=>[
                    "type"=>"email",
                    "min"=>8,
                    "max"=>320,
                    "label"=>"Votre email",
                    "required"=>true,
                    "error"=>"Votre email doit faire entre 8 et 320 caractères"
                ],
            ]

        ];
    }


}