<?php
namespace App\Forms;

use App\Models\Tag as  TagModel;

class AddProject
{

    public static function getConfig(): array
    {
        $tag = new TagModel();
        $tags = $tag->getAllData("object");

        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Enregistrer un projet"
            ],
            "inputs"=>[
                "title"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>500,
                    "label"=>"Titre du projet",
                    "required"=>true,
                    "error"=>"Votre titre doit faire entre 2 et 500 caractères"
                ],
                "content"=>[
                    "type"=>"text",
                    "min"=>2,
                    "label"=>"Contenu",
                    "required"=>true,
                    "error"=>"",
                ],
                "tag"=>[
                    "type"=>"select",
                    "label"=>"Catégorie du projet",
                    "option"=>$tags, 
                    "required"=>false,
                ],
            ]
        ];
    }
}