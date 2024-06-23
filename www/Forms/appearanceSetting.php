<?php
namespace App\Forms;

use App\Models\Page as PageModel;
use App\Models\Tag as TagModel;
use App\Models\Status as StatusModel;
class appearanceSetting
{
    public static function getConfig(): array
    {
        return [
            "config" => [
                "action" => "",
                "method" => "POST",
                "submit" => "Enregistrer"
            ],
            "inputs" => [
                "light-primary_color" => [
                    "type" => "color",
                    "label" => "Couleur principale",
                    "part" => "Couleur du mode claire"
                ],
                "light-secondary_color" => [
                    "type" => "color",
                    "label" => "Couleur secondaire",
                ],
                "light-accent_color" => [
                    "type" => "color",
                    "label" => "Couleur d'accentuation",
                ],
                "dark-primary_color" => [
                    "type" => "color",
                    "label" => "Couleur principale",
                    "part" => "Couleur du mode sombre"
                ],
                "dark-secondary_color" => [
                    "type" => "color",
                    "label" => "Couleur secondaire",
                ],
                "dark-accent_color" => [
                    "type" => "color",
                    "label" => "Couleur d'accentuation",
                ],
                "primary_font" => [
                    "type" => "select",
                    "label" => "Police des titres",
                    "option" => [['id'=>"roboto", "name"=>"Roboto"], 
                        ['id'=>"open-sans", "name"=>"Open Sans"],
                        ['id'=>"montserrat", "name"=>"Montserrat"],
                        ['id'=>"lato", "name"=>"Lato"],
                        ['id'=>"noto-sans", "name"=>"Noto Sans"]],
                ], 
                "secundary_font" => [
                    "type" => "select",
                    "label" => "Police du texte",
                    "option" => [['id'=>"roboto", "name"=>"Roboto"], 
                        ['id'=>"open-sans", "name"=>"Open Sans"],
                        ['id'=>"montserrat", "name"=>"Montserrat"],
                        ['id'=>"lato", "name"=>"Lato"],
                        ['id'=>"noto-sans", "name"=>"Noto Sans"]],
                ], 
            ]
        ];
    }
}