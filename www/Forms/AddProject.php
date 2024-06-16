<?php
namespace App\Forms;

use App\Models\Tag;
use App\Models\Media;
use App\Core\SQL;

class AddProject
{

    public static function getConfig(): array
    {
        $tag = new Tag();
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

        $media = new Media();
        $medias = $media->getAllData('object');
        $arrayMedias = [];
        if (!empty($medias)) {
            foreach ($medias as $mediaObject) {
              $arrayMedias[] = [
                "id" => $mediaObject->getUrl(),
                "name" => $mediaObject->getName(),
              ];
            }
        } else {
            $arrayMedias[] = [
                "id" => '',
                "name" => 'Aucune image disponible',
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
                    "error"=>"Le contenu est requis et doit avoir au minimum 2 caractères",
                ],
                "featured_image"=>[
                    "type"=>"checkbox",
                    "option"=>$arrayMedias,
                    "label"=>"Image mise en avant",
                    "error"=>"Le format du fichier n'est pas pris en compte"
                ],
                "slug"=>[
                    "type"=>"text",
                    "label"=>"Slug",
                    "max"=>255,
                    "error"=>"Le slug doit avoir au moins 255 caractères."
                ],
                "tag"=>[
                    "type"=>"select",
                    "name"=>'tag[]',
                    "label"=>"Catégorie du projet",
                    "option"=>$formattedTags, 
                    "multiple"=>true,
                ],
            ],
        ];
    }
}