<?php
namespace App\Forms;

class EditUser
{
    public static function getConfig(): array
    {
        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Sauvegarder"
            ],
            "inputs"=>[
                "photo"=>[
                    "type"=>"file",
                    "label"=>"Photo de profil",
                ],
                "lastname"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Nom",
                    "required"=>true,
                    "error"=>"Le nom doit faire entre 2 et 50 caractères"
                ],
                "firstname"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Prénom",
                    "required"=>true,
                    "error"=>"Le prénom doit faire entre 2 et 50 caractères"
                ],
                "email"=>[
                    "type"=>"email",
                    "label" => "Email",
                    "required"=>true,
                    "min"=>8,
                    "max"=>320,
                    "error"=>"Veuillez entrer une adresse email valide",
                ],
                "birthday"=>[
                    "type"=>"date",
                    "label"=>"Votre date de naissance",
                    "required"=>true,
                    "error"=>"Ce champ ne doit pas etre vide",
                ],
                "city"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Ville",
                    "required"=>true,
                    "error"=>"Votre ville doit faire entre 2 et 50 caractères",
                ],
                "country"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Pays",
                    "required"=>true,
                    "error"=>"Votre pays doit faire entre 2 et 50 caractères",
                ],
                "occupation"=>[
                    "type"=>"text",
                    "label" => "Profession",
                    "min"=>2,
                    "max"=>500,
                    "error"=>"",
                ],
                "description"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>1000,
                    "label"=>"Description",
                    "error"=>"Ce champ doit faire entre 2 et 1000 caractères",
                ],
                "link"=>{
                    "type"=>"text",
                    "min"=>2,
                    "max"=>255,
                    "label"=>"Votre parcours académique",
                    "required"=>true,
                    "error"=>"ce champ doit faire entre 2 et 255 caractères",
                }
                "experience"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>255,
                    "label"=>"Votre expérience professionnelle",
                    "required"=>true,
                    "error"=>"ce champ doit faire entre 2 et 255 caractères",
                ],
                "study"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>255,
                    "label"=>"Votre parcours académique",
                    "required"=>true,
                    "error"=>"ce champ doit faire entre 2 et 255 caractères",
                ],
                "competence"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>255,
                    "label"=>"Vos compétences",
                    "required"=>true,
                    "error"=>"ce champ doit faire entre 2 et 255 caractères",
                ],  
                "interest"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>255,
                    "label"=>"Vos intérets",
                    "required"=>true,
                    "error"=>"ce champ doit faire entre 2 et 255 caractères",
                ],              
            ]

        ];
    }
}