<?php
namespace App\Forms;

use App\Models\Tag as  TagModel;
use App\Core\SQL;

class AddProject
{

    public static function getConfig(): array
    {
        $tag = new TagModel();
        $tags = $tag->getAllData('object');

        $formattedTags = [];
        if (!empty($tags)) {
            foreach ($tags as $tagObject) {
              $formattedTags[] = [
                "id" => $tagObject->getId(),
                "name" => $tagObject->getName(),
              ];
            }
        } else {
            $formattedTags[] = [
                "id" => '0',
                "name" => 'Aucune catgégorie disponible',
                "selected" => true,
            ];
        }

        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Publier",
            ],
            "inputs"=>[
                "title"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>1000,
                    "label"=>"Titre du projet",
                    "required"=>true,
                    "error"=>"Votre titre doit faire entre 2 et 1000 caractères"
                ],
                "content"=>[
                    "type"=>"textarea",
                    "min"=>2,
                    "id"=>"content",
                    "label"=>"Contenu",
                    "required"=>true,
                    "error"=>"Le contenu est requis et doit avoir au minimum 2 caractères",
                ],
                "slug"=>[
                    "type"=>"text",
                    "label"=>"Slug",
                    "max"=>255,
                    "error"=>"Le slug doit avoir au moins 255 caractères."
                ],
                "tag"=>[
                    "type"=>"select",
                    "label"=>"Catégorie du projet",
                    "option"=>$formattedTags, 
                ],
                "submit-draft"=>[
                    "label"=>"Enregistrer en tant que brouillon",
                    "type"=>"submit",
                    "value"=>"Sauvegarder", 
                ],
            ],
        ];
    }
}