<?php
namespace App\Forms;

class AddMedia
{
    public static function getConfig(): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Enregistrer un média",
                "enctype"=>"multipart/form-data",
            ],
            "inputs"=>[
                "media"=>[
                    "type"=>"file",
                    "label"=>"Média",
                    "required"=>true,
                    "accept"=>"image/png, image/jpeg, video/mp4, audio/mp3, application/pdf, image/svg",
                    "error"=>"Le format du fichier n'est pas pris en compte"
                ],
                "title"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>1000,
                    "label"=>"Titre",
                    "required"=>true,
                    "error"=>"Le titre est requis et doit faire entre 2 et 1000 caractères"
                ],
                "description"=>[
                    "type"=>"textarea",
                    "min"=>2,
                    "max"=>4000,
                    "label"=>"Description",
                    "required"=>true,
                    "error"=>"La description est requise et doit faire entre 2 et 4000 caractères"
                ]
            ]
        ];
    }
}