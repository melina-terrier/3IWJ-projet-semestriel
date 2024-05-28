<?php
namespace App\Forms;

class AddTag
{
    public static function getConfig(): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Ajouter une nouvelle catégorie"
            ],
            "inputs"=>[
                "name"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>255,
                    "label"=>"Nom",
                    "required"=>true,
                    "error"=>"Le nom est requis et doit être compris entre 2 et 255 caractères."
                ],
                "slug"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>255,
                    "label"=>"Slug",
                    "required"=>true,
                    "error"=>"Le slug est requis et doit être compris entre 2 et 255 caractères."
                ],
                "description"=>[
                    "type"=>"textarea",
                    "min"=>2,
                    "max" => 1000,
                    "required"=>false,
                    "label"=>"Description",
                    "error"=>"Votre description doit faire entre 2 et 1000 caractères."
                ]
            ]

        ];
    }


}