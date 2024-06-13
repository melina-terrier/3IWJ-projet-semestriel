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
                "submit"=>"Réinitialiser le mot de passe"
            ],
            "token"=>[
                "type"=>"hidden", 
                "label" => "token", 
                "value" => $token, 
                "required"=>true
            ],
            "password"=>[
                "type"=>"password",
                "label"=>"Nouveau mot de passe",
                "required"=>true,
                "error"=>"Votre mot de passe doit faire au minimum 8 caractères avec des lettres minscules, majuscules et des chiffres"
            ],
            "passwordConfirm"=>[
                "type"=>"password",
                "label"=>"Confirmation du nouveau mot de passe",
                "required"=>true,
                "confirm"=>"password",
                "error"=>"Votre mot de passe ne correspond pas"
            ], 
        ];
    }
}