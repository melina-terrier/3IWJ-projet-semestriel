<?php
namespace App\Forms;
class Register
{

    public static function getConfig(): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"S'inscrire"
                ],
            "inputs"=>[
                "lastname"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Nom",
                    "required"=>true,
                    "error"=>"Votre nom doit faire entre 2 et 50 caractères"
                ],
                "firstname"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Prénom",
                    "required"=>true,
                    "error"=>"Votre prénom doit faire entre 2 et 50 caractères"
                ],
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
                    "error"=>"Votre mot de passe doit faire au minimum 8 caractères avec des lettres minscules, majuscules et des chiffres"
                ],
                "passwordConfirm"=>[
                    "type"=>"password",
                    "label"=>"Confirmation du mot de passe",
                    "required"=>true,
                    "confirm"=>"password",
                    "error"=>"Le mot de passe ne correspond pas"
                ],
            ]

        ];
    }


}