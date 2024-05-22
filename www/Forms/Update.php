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
                "study"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>255,
                    "placeholder"=>"Votre parcours académique",
                    "required"=>true,
                    "error"=>"ce champ doit faire entre 2 et 255 caractères"
                ],
                "experience"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>255,
                    "placeholder"=>"Votre expérience professionnelle",
                    "required"=>true,
                    "error"=>"ce champ doit faire entre 2 et 255 caractères"
                ],
                "interest"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>255,
                    "placeholder"=>"Vos intérets",
                    "required"=>true,
                    "error"=>"ce champ doit faire entre 2 et 255 caractères"
                ],
                "competence"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>255,
                    "placeholder"=>"Vos compétences",
                    "required"=>true,
                    "error"=>"ce champ doit faire entre 2 et 255 caractères"
                ],
                "birthday"=>[
                    "type"=>"date",
                    "placeholder"=>"Votre date de naissance",
                    "required"=>true,
                    "error"=>"Ce champ ne doit pas etre vide"
                ],
                "contact"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "placeholder"=>"Votre contact",
                    "required"=>true,
                    "error"=>"Votre prénom doit faire entre 2 et 50 caractères"
                ],
                "description"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>255,
                    "placeholder"=>"Votre description",
                    "required"=>true,
                    "error"=>"Ce champ doit faire entre 2 et 255 caractères"
                ]
            ]

        ];
    }


}