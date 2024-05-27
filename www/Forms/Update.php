<?php
namespace App\Forms;
class Update
{

    public static function getConfig(): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"S'enregistrer"
                ],
            "inputs"=>[
                "adress"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "placeholder"=>"Votre adresse",
                    "required"=>true,
                    "error"=>"Votre adresse doit faire entre 2 et 50 caractères"
                ],
                "Photo"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>255,
                    "placeholder"=>"Modifer votre photo",
                    "required"=>true,
                    "error"=>"ce champ doit faire entre 2 et 255 caractères"
                ],
                "telephone"=>[
                    "type"=>"int",
                    "min"=>2,
                    "max"=>255,
                    "placeholder"=>"Votre télephone",
                    "required"=>true,
                    "error"=>"ce champ doit faire entre 2 et 255 caractères"
                ],
                "date"=>[
                    "type"=>"date",
                    "min"=>2,
                    "max"=>255,
                    "placeholder"=>"Votre date de naissance",
                    "required"=>true,
                    "error"=>"ce champ doit faire entre 2 et 255 caractères"
                ],
                "description"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>255,
                    "placeholder"=>"Votre déscription de profil",
                    "required"=>true,
                    "error"=>"ce champ doit faire entre 2 et 255 caractères"
                ],
                
            ]

        ];
    }


}