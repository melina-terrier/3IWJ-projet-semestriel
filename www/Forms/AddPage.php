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
                    "max"=>1000,
                    "label"=>"Titre de la page",
                    "required"=>true,
                    "error"=>"Le titre de la page doit faire entre 2 et 1000 caractères",
                ],
                "content"=>[
                    "type"=>"textarea",
                    "id"=>"content",
                    "label"=>"Contenu",
                    "min"=>2,
                    "required"=>true,
                    "error"=>"Le contenu est requis et doit avoir au minimum 2 caractères",
                ],
                "slug"=>[
                    "type"=>"text",
                    "label"=>"Slug",
                    "max"=>255,
                    "error"=>"Le slug doit avoir au moins 255 caractères."
                ],
                "submit-draft"=>[
                    "label"=>"Enregistrer en tant que brouillon",
                    "type"=>"submit",
                    "value"=>"Sauvegarder", 
                ],
            ]
        ];
    }

}