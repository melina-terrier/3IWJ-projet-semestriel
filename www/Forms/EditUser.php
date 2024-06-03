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
                    // "value" => $this->userData['occupation'] ?? '',
                ],
                "adress"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Votre adresse",
                    "required"=>true,
                    "error"=>"Votre adresse doit faire entre 2 et 50 caractères",
                    // "value" => $this->userData['email'] ?? '',
                ],
                "study"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>255,
                    "label"=>"Votre parcours académique",
                    "required"=>true,
                    "error"=>"ce champ doit faire entre 2 et 255 caractères",
                    // "value" => $this->userData['email'] ?? '',
                ],
                "experience"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>255,
                    "label"=>"Votre expérience professionnelle",
                    "required"=>true,
                    "error"=>"ce champ doit faire entre 2 et 255 caractères",
                    // "value" => $this->userData['email'] ?? '',
                ],
                "interest"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>255,
                    "label"=>"Vos intérets",
                    "required"=>true,
                    "error"=>"ce champ doit faire entre 2 et 255 caractères",
                    // "value"=>$this->userData['email'] ?? '',
                ],
                "competence"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>255,
                    "label"=>"Vos compétences",
                    "required"=>true,
                    "error"=>"ce champ doit faire entre 2 et 255 caractères",
                    // "value" => $this->userData['email'] ?? '',
                ],
                "birthday"=>[
                    "type"=>"date",
                    "label"=>"Votre date de naissance",
                    "required"=>true,
                    "error"=>"Ce champ ne doit pas etre vide",
                    // "value" => $this->userData['email'] ?? '',
                ],
                "contact"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Votre contact",
                    "required"=>true,
                    "error"=>"Votre prénom doit faire entre 2 et 50 caractères",
                    // "value" => $this->userData['email'] ?? '',
                ],
                "description"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>1000,
                    "label"=>"Description",
                    "error"=>"Ce champ doit faire entre 2 et 1000 caractères",
                    // "value" => $this->userData['description'] ?? '',
                ],
            ]

        ];
    }
}