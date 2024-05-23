<?php
namespace App\Forms;
class Page
{

    public static function getConfig(): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Créer une page"
            ],
            "inputs"=>[
                "title"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "placeholder"=>"Validez",
                    "required"=>true,
                    "error"=>"Votre setting doit faire entre 2 et 50 caractères"
                ]
            ]

        ];
    }


}