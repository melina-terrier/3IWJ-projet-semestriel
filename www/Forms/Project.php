<?php
namespace App\Forms;
class Project
{

    public static function getConfig(): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Enregistrer un projet"
            ],
            "inputs"=>[
                "title"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>64,
                    "placeholder"=>"Votre titre",
                    "required"=>true,
                    "error"=>"Votre titre doit faire entre 2 et 64 caractères"
                ],
                "content"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>155,
                    "placeholder"=>"Votre contenu",
                    "required"=>true,
                    "error"=>"Votre contenu doit faire entre 2 et 155 caractères"
                ],
                "date_to_create"=>[
                    "type"=>"date",
                    "placeholder"=>"Votre contenu",
                    "required"=>true,
                    "error"=>"Ce champ ne doit pas etre vide"
                ]
        ]

        ];
    }


}