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
<<<<<<< HEAD
                "Title"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>64,
                    "placeholder"=>"Votre titre",
=======
                "title"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>64,
                    "placeholder"=>"Votre pseudo",
>>>>>>> 6c501f1db55d62bf1e1edcc546dfce12f25dc3b4
                    "required"=>true,
                    "error"=>"Votre pseudo doit faire entre 2 et 64 caractères"
                ],
                "content"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>255,
<<<<<<< HEAD
                    "placeholder"=>"Votre contenu",
=======
                    "placeholder"=>"Votre email",
>>>>>>> 6c501f1db55d62bf1e1edcc546dfce12f25dc3b4
                    "required"=>true,
                    "error"=>"Votre email doit faire entre 2 et 255 caractères"
                ],
                "date"=>[
                    "type"=>"date",
                    "placeholder"=>"Votre contenu",
                    "required"=>true,
                    "error"=>"Ce champ ne doit pas etre vide"
                ]
            ]

        ];
    }


}