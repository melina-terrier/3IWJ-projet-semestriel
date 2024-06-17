<?php

namespace App\Forms;

class EditPassword
{
    public static function getConfig(): array
    {
        return [
            "config"=> [
                "method"=>"POST",
                "action"=>"",
                "submit"=>"Changer le mot de passe",
                "class"=>"form"
            ],
            "inputs"=>[
                "old-password"=>[
                    "type"=>"password",
                    "label"=>"Mot de passe actuel",
                    "required"=>true,
                    "min"=>8,
                    "max"=>64,
                    "error"=>"Votre mot de passe doit faire au minimum 8 caractères avec des lettres minscules, majuscules et des chiffres"
                ],
                "password"=>[
                    "type"=>"password",
                    "label"=>"Nouveau mot de passe",
                    "required"=>true,
                    "min"=>8,
                    "max"=>64,
                    "error"=>"Votre mot de passe doit faire au minimum 8 caractères avec des lettres minscules, majuscules et des chiffres"
                ],
                "passwordConfirm"=>[
                    "type"=>"password",
                    "label"=>"Confirmer le mot de passe",
                    "required"=>true,
                    "min"=>8,
                    "max"=>64,
                    "confirm"=>"password",
                    "error"=>"La confirmation de votre mot de passe ne correspond pas au mot de passe."
                ],
            ]
        ];
    }


}
