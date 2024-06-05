<?php
namespace App\Forms;

class EditMedia
{
    public static function getConfig(): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Enregistrer un média",
                "enctype"=>"multipart/form-data",
            ],
            "inputs"=>[
                "title"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Titre",
                    "required"=>true,
                    "error"=>"Votre titre doit faire entre 2 et 50 caractères"
                ],
                "url"=>[
                    "type"=>"text",
                    "label"=>"Url",

                ],
                "description"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>500,
                    "label"=>"Description",
                    "required"=>true,
                    "error"=>"Votre description doit faire entre 2 et 500 caractères"
                ]
            ]
        ];
    }
}