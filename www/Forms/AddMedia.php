<?php
namespace App\Forms;

class AddMedia
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
                    "label"=>"Votre url",
                    "required"=>true,
                    "error"=>"Votre url doit faire entre 2 et 50 caractères"
                ],
                "title"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Votre titre",
                    "required"=>true,
                    "error"=>"Votre titre doit faire entre 2 et 50 caractères"
                ],
                "description"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>500,
                    "label"=>"Votre description",
                    "required"=>true,
                    "error"=>"Votre description doit faire entre 2 et 500 caractères"
                ]
            ]

        ];
    }


}