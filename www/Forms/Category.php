<?php
namespace App\Forms;
class Category
{

    public static function getConfig(): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Enregistrer une catégorie"
            ],
            "inputs"=>[
                "title"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "placeholder"=>"Votre catégorie",
                    "required"=>true,
                    "error"=>"Votre titre doit faire entre 2 et 50 caractères"
                ]
            ]

        ];
    }


}