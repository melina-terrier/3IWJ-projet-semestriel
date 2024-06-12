<?php
namespace App\Forms;

class Setting
{

    public static function getConfig(): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Enregistrer"
            ],
            "inputs"=>[
                "title"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Titre du site ",
                    "required"=>true,
                    "error"=>""
                ],
                "slogan"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Slogan du site ",
                    "error"=>""
                ],
                "logo"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Logo du site ",
                    "error"=>""
                ],
                "homepage"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Page d'accueil du site ",
                    "error"=>""
                ],
                "menu"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Menu du site ",
                    "error"=>""
                ],
                "footer"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Footer du site ",
                    "error"=>""
                ],
                "color"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Couleur du site ",
                    "error"=>""
                ],
                "font"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Police du site ",
                    "error"=>""
                ]
            ]
        ];
    }
}
