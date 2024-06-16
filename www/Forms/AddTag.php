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
                    "max"=>255,
                    "error"=>"Le slug doit avoir au moins 255 caractères."
                ],
                "description"=>[
                    "type"=>"textarea",
                    "label"=>"Description",
                    "max"=>4000,
                    "error"=>"La description doit avoir au moins 4000 caractères."
                ]
            ]
        ];
    }
}