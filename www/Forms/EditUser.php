<?php
namespace App\Forms;

class EditUser
{
    public static function getConfig(): array
    {
        return [
            "config"=>[
                "enctype"=>"multipart/form-data",
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Sauvegarder",
            ],
            "inputs"=>[
                "photo"=>[
                    "type"=>"file",
                    "required"=>true,
                    "label"=>"Photo de profil",
                    "accept"=>"image/png, image/jpeg",
                    "error"=>"Le format du fichier n'est pas pris en compte",
                    "part"=>"Information de base"
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
                "occupation"=>[
                    "type"=>"text",
                    "label" => "Profession",
                    "min"=>2,
                    "max"=>500,
                    "error"=>"",
                ],
                "birthday"=>[
                    "type"=>"date",
                    "label"=>"Votre date de naissance",
                    "required"=>true,
                    "error"=>"Ce champ ne doit pas etre vide",
                ],
                "country"=>[
                    "type"=>"select",
                    "label"=>"Zone géographique",
                    "option"=>[["id"=>"", "name"=>"Tous les pays"], ["id"=>"France", "name"=>"France"], ["id"=>"Etats-Unis", "name"=>"Etats-Unis"], ["id"=>"Belgique", "name"=>"Belgique"], ["id"=>"Allemagne", "name"=>"Allemagne"]],
                    "error"=>"Votre pays doit faire entre 2 et 50 caractères",
                ],
                "city"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Ville",
                    "required"=>true,
                    "error"=>"Votre ville doit faire entre 2 et 50 caractères",
                ],
                "website"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>255,
                    "label"=>"Lien vers votre portfolio personnel",
                    "required"=>true,
                    "error"=>"Votre ville doit faire entre 2 et 50 caractères",
                    "part"=>"Sur le web",
                ],
                "link"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>255,
                    "label"=>"Lien vers vos réseaux sociaux",
                    "required"=>true,
                    "error"=>"ce champ doit faire entre 2 et 255 caractères",
                ],

                "description"=>[
                    "type"=>"textarea",
                    "min"=>2,
                    "label"=>"Description",
                    "part"=>"A propos de vous",
                    "error"=>"Ce champ doit faire entre 2 et 1000 caractères",
                ],
                
                "experience"=>[
                    "type"=>"textarea",
                    "min"=>2,
                    "label"=>"Votre expérience professionnelle",
                    "required"=>true,
                    "error"=>"ce champ doit faire entre 2 et 255 caractères",
                ],
                "study"=>[
                    "type"=>"textarea",
                    "min"=>2,
                    "label"=>"Votre parcours académique",
                    "required"=>true,
                    "error"=>"ce champ doit faire entre 2 et 255 caractères",
                ],
                "competence"=>[
                    "type"=>"textarea",
                    "min"=>2,
                    "label"=>"Vos compétences",
                    "required"=>true,
                    "error"=>"ce champ doit faire entre 2 et 255 caractères",
                ],  
                "interest"=>[
                    "type"=>"textarea",
                    "min"=>2,
                    "label"=>"Vos intérets",
                    "required"=>true,
                    "error"=>"ce champ doit faire entre 2 et 255 caractères",
                ],              
            ]

        ];
    }
}
