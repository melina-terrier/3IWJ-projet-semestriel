<?php
namespace App\Forms;

class ResetPassword
{
    public static function getConfig(): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Changer le mot de passe"
            ],
            "inputs"=>[
                "token"=>[
                    "type"=>"hidden", 
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
                    "error"=>"Votre mot de passe ne correspond pas"
                ], 
            ]
        ];
    }
}