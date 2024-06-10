<?php
namespace App\Forms;
class Login
{

    public static function getConfig(): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Se connecter"
            ],
            "inputs"=>[
                "email"=>[
                    "type"=>"email",
                    "min"=>8,
                    "max"=>320,
                    "label"=>"Email",
                    "required"=>true,
                    "error"=>"Le format de l'email est incorrect"
                ],
                "password"=>[
                    "type"=>"password",
                    "label"=>"Mot de passe",
                    "required"=>true,
                    "error"=>"Votre mot de passe doit faire au minimum 8 caractères avec des lettres et des chiffres"
                ]
            ]
        ];
    }
}