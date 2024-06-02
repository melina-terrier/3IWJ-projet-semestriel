<?php
namespace App\Forms;

use App\Models\Tag as  TagModel;
use App\Core\SQL;

class AddProject
{

    public static function getConfig(): array
    {
        $tag = new TagModel();
        $sql = new SQL();
        $status = $sql->getDataId("published");
        $tags = [];
        $tagObjects = $tag->getOneBy(["status_id" => $status], "object");
        if (is_array($tagObjects)) {
            foreach ($tagObjects as $tagObject) {
              $tags[] = [
                "id" => $tagObject->getId(),
                "name" => $tagObject->getName(),
              ];
            }
        } else {
            $tags[] = [
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
                    "max"=>500,
                    "label"=>"Titre du projet",
                    "required"=>true,
                    "error"=>"Votre titre doit faire entre 2 et 500 caractères"
                ],
                "content"=>[
                    "type"=>"text",
                    "min"=>2,
                    "id"=>"content",
                    "label"=>"Contenu",
                    "error"=>"",
                ],
                "slug"=>[
                    "type"=>"text",
                    "label"=>"Slug",
                ],
                "tag"=>[
                    "type"=>"select",
                    "label"=>"Catégorie du projet",
                    "option"=>$tags, 
                ],
            ],
        ];
    }
}