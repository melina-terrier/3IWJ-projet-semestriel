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
                "submit"=>"Installer",
            ],
            "inputs"=>[
                "site_title"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Titre du site",
                    "required"=>true,
                    "error"=>"Le titre doit faire entre 2 et 50 caractères"
                ],
                "lastname"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Nom",
                    "required"=>true,
                    "error"=>"Votre nom doit faire entre 2 et 50 caractères",
                    "part"=>"Création de votre compte d'administrateur"
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
                    "label"=>"Adresse e-mail",
                    "required"=>true,
                    "error"=>"Cette adresse e-mail n'est pas valide"
                ],
                "password"=>[
                    "type"=>"password",
                    "label"=>"Mot de passe",
                    "min"=>8, 
                    "max"=>64,
                    "required"=>true,
                    "error"=>"Votre mot de passe doit faire au minimum 8 caractères avec des lettres minscules, majuscules et des chiffres"
                ],
                "passwordConfirm"=>[
                    "type"=>"password",
                    "min"=>8,
                    "max"=>64,
                    "label"=>"Confirmation du mot de passe",
                    "required"=>true,
                    "confirm"=>"password",
                    "error"=>"La confirmation de votre mot de passe ne correspond pas au mot de passe."
                ],
                "dbname"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>64,
                    "label"=> "Nom de la base de données",
                    "required"=>true,
                    "error"=>"Le nom de la base de données est requis et doit faire entre 2 et 64 caractères",
                    "part"=>"Information de la base de donnée",
                ],
                "dbuser"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>32,
                    "label" => "Identifiant",
                    "required"=>true,
                    "error"=>"L'identifiant est requis et doit faire entre 2 et 32 caractères",
                ],
                "dbpwd"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>64,
                    "label" => "Mot de passe",
                    "required"=>true,
                    "error"=>"Le mot de passe de la base de données est requis et doit faire entre 2 et 64 caractères",
                ],
                "dbhost"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>255,
                    "label"=>"Hôte de la base de donnée",
                    "required"=>true,
                    "error"=>"L'hôte de la base de donnée est requis et doit faire entre 2 et 255 caractères",
                ],
                "table_prefix"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>25,
                    "label"=>"Préfixe des tables",
                    "required"=>true,
                    "error"=>"Le préfixe est requis et doit faire entre 2 et 25 caractères",
                ],
            ]
        ];
    }
}