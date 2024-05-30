<?php

namespace App\Forms;

class Installer
{
    public static function getConfig(): array
    {
        return [
            "config"=> [
                "method"=>"POST",
                "action"=>"",
                "submit"=>"Installer le site",
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
                "dbname"=>[
                    "type"=>"text",
                    "min"=>"",
                    "max"=>"",
                    "label" => "Nom de la base de données",
                    "required"=>true,
                    "error"=>"Veuillez entrer le nom de la base de données",

                ],
                "dbuser"=>[
                    "type"=>"text",
                    "min"=>"",
                    "max"=>"",
                    "label" => "Utilisateur de la base de données",
                    "required"=>true,
                    "error"=>"Veuillez entrer l'utilisateur de la base de données",

                ],
                "dbpwd"=>[
                    "type"=>"password",
                    "min"=>"",
                    "max"=>"",
                    "label" => "Mot de passe de la base de données",
                    "required"=>true,
                    "error"=>"Veuillez entrer le mot de passe de la base de données",

                ],
                // "table_prefix"=>[
                //     "type"=>"text",
                //     "min"=>"",
                //     "max"=>"",
                //     "label" => "Préfixe pour les tables (ex: mysite_)",
                //     "required"=>true,
                //     "error"=>"Veuillez entrer un préfixe pour les tables de la base de données",
                // ],
            ]
        ];
    }
}