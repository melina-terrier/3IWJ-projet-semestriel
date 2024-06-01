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
                    "label"=>"Nom",
                    "required"=>true,
                    "error"=>"Le nom doit faire entre 2 et 50 caractères"
                ],
                "firstname"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Prénom",
                    "required"=>true,
                    "error"=>"Le prénom doit faire entre 2 et 50 caractères"
                ],
                "email"=>[
                    "type"=>"email",
                    "min"=>8,
                    "max"=>320,
                    "label"=>"Email",
                    "required"=>true,
                    "error"=>"L'email doit faire entre 8 et 320 caractères"
                ],
                "role"=>[
                    "type"=>"select",
                    "label"=>"Rôle",
                    "required"=>true,
                    "option"=>["admin", "user"], 
                    "error"=>"Veuillez sélectionner un rôle"
                ],
            ]

        ];
    }
}