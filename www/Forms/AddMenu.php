<?php
namespace App\Forms;


class AddMenu{

    public static function getConfig(): array
    {
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>"",
                "submit"=>"Ajouter",
            ],
            "inputs"=>[
                "name"=>[ 
                    "type"=>"text",
                    "label"=>"Nom du menu",
                    "minLength"=>2,
                    "maxLength"=>50,
                    "error"=>"Le titre est requis et doit faire entre 2 et 50 caractères",
                    "required"=>true,
                ],
            ]
        ];
    }
}

