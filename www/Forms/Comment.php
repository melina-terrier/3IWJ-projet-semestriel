<?php
namespace App\Forms;
class Comment
{

    public static function getConfig(): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Ecrire un commentaire"
            ],
            "inputs"=>[
                "pseudo"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "placeholder"=>"Votre pseudo",
                    "required"=>true,
                    "error"=>"Votre pseudo doit faire entre 2 et 50 caractères"
                ],
                "email"=>[
                    "type"=>"email",
                    "min"=>8,
                    "max"=>320,
                    "placeholder"=>"Votre email",
                    "required"=>true,
                    "error"=>"Votre email doit faire entre 8 et 320 caractères"
                ],
                "comment"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>255,
                    "placeholder"=>"Votre commentaire",
                    "required"=>true,
                    "error"=>"Votre commentaire doit faire entre 2 et 255 caractères"
                ]
            ]

        ];
    }


}