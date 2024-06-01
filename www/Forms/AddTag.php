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
                    "label"=>"Slug",
                ],
                "description"=>[
                    "type"=>"textarea",
                    "label"=>"Description",
                ]
            ]
        ];
    }
}