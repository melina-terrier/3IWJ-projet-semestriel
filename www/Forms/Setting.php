<?php
namespace App\Forms;
class Setting
{

    public static function getConfig(): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Enregistrer un setting"
            ],
            "inputs"=>[
                "title"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "placeholder"=>"Votre setting",
                    "required"=>true,
                    "error"=>"Votre setting doit faire entre 2 et 50 caractères"
                ]
            ]

        ];
    }


}