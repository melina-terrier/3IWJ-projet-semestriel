<?php
namespace App\Forms;
class Media
{

    public static function getConfig(): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Enregistrer un média"
            ],
            "inputs"=>[
                "url"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "placeholder"=>"Votre url",
                    "required"=>true,
                    "error"=>"Votre url doit faire entre 2 et 50 caractères"
                ],
                "title"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "placeholder"=>"Votre titre",
                    "required"=>true,
                    "error"=>"Votre titre doit faire entre 2 et 50 caractères"
                ]
            ]

        ];
    }


}