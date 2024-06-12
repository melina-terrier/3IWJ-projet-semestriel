<?php
namespace App\Forms;

use App\Models\Page as PageModel;
use App\Models\Status as StatusModel;
class Setting
{
    public static function getConfig(): array
    {

        $page = new PageModel();
        $statusModel = new StatusModel();
        $status = $statusModel->getOneBy(["status"=>"published"], 'object');
        $statusId = $status->getId();
        $pages = $page->getAllDataWithWhere(["status_id"=>$statusId], 'object');

        $formattedPages = [];
        if (!empty($pages)) {
            foreach ($pages as $page) {
                    $formattedPages[] = [
                      "id" => $page->getId(),
                      "name" => $page->getTitle(),
                    ];
            }
        } else {
            $formattedPages[] = [
                "id" => '0',
                "name" => 'Aucune page disponible',
                "selected" => true,
            ];
        }

        return [
            "config" => [
                "action" => "",
                "method" => "POST",
                "submit" => "Enregistrer"
            ],
            "inputs" => [
                "icon" => [
                    "type" => "file",
                    "label" => "",
                    "required" => true,
                    "error" => ""
                ],
                "title" => [
                    "type" => "text",
                    "min" => 2,
                    "max" => 50,
                    "label" => "Titre du site",
                    "required" => true,
                    "error" => ""
                ],
                "slogan" => [
                    "type" => "text",
                    "min" => 2,
                    "max" => 50,
                    "label" => "Slogan du site",
                    "required" => true,
                    "error" => ""
                ],
                "description" => [
                    "type" => "textarea",
                    "min" => 2,
                    "max" => 255,
                    "label" => "Description du site",
                    "required" => true,
                    "error" => ""
                ],
                "logo" => [
                    "type" => "file",
                    "label" => "Logo du site",
                    "required" => false,
                    "error" => ""
                ],
                "timezone" => [
                    "type" => "select",
                    "label" => "choisir le Fuseau horaire",
                    "options" => \DateTimeZone::listIdentifiers(),
                    "required" => true,
                    "error" => ""
                ], 
                "homepage" => [
                    "type" => "select",
                    "label" => "Sélectionner la page d'accueil",
                    "required" => true,
                    "option" => $formattedPages,
                    "error" => ""
                ],
                "primary_color" => [
                    "type" => "color",
                    "label" => "Sélectionner la couleur principale",
                    "error" => ""
                ],
                "secondary_color" => [
                    "type" => "color",
                    "label" => "Sélectionner une deuxième couleur",
                    "error" => ""
                ],
                "accent_color" => [
                    "type" => "color",
                    "label" => "Sélectionner une couleur accentué",
                    "error" => ""
                ],
                "primary_font" => [
                    "type" => "select",
                    "label" => "Choisir la police pour les titres",
                    "options" => "",
                    "required" => true,
                    "error" => ""
                ], 
                "secundary_font" => [
                    "type" => "select",
                    "label" => "Choisir la police pour le texte",
                    "options" => "",
                    "required" => true,
                    "error" => ""
                ], 
            ]
        ];
    }
}
