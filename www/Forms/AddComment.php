<?php
namespace App\Forms;

class AddComment
{

    public static function getConfig(): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Publier"
            ],
            "inputs"=>[
                "comment"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>1000,
                    "label"=>"Laisser un commentaire",
                    "required"=>true,
                    "error"=>"Votre commentaire doit faire entre 2 et 1000 caractères"
                ],
                "email"=>[
                    "type"=>"email",
                    "min"=>8,
                    "max"=>320,
                    "label"=>"Votre email",
                    "required"=>true,
                    "error"=>"Le format de l'email est incorrect"
                ],
            ]
        ];
    }

}