<?php
namespace App\Forms;

class AddPage
{
    public static function getConfig(): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Publier"
            ],
            "inputs"=>[
                "title"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>500,
                    "label"=>"Titre de la page",
                    "required"=>true,
                    "error"=>"Le titre de la page doit faire entre 2 et 500 caractères",
                ],
                "content"=>[
                    "type"=>"textarea",
                    "id"=>"content",
                    "label"=>"Contenu de la page",
                    "required"=>true,
                    "error"=>"",
                ]
            ]
        ];
    }
}