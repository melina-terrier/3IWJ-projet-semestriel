<?php
namespace App\Forms;

class RequestPassword
{
    public static function getConfig(): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Envoyer le lien"
            ],
            "inputs"=>[
                "email"=>[
                    "type"=>"email",
                    "min"=>8,
                    "max"=>320,
                    "label"=>"Email",
                    "required"=>true,
                    "error"=>"Le format de l'email est incorrect"
                ]
            ]
            
        ];
    }
}