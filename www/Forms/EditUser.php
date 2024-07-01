<?php
namespace App\Forms;

class EditUser
{
    public static function getConfig(): array
    {
        return [
            'config'=>[
                'action'=>'',
                'method'=>'POST',
                'submit'=>'Sauvegarder',
                'enctype'=>'multipart/form-data',
            ],
            'inputs'=>[
                'photo'=>[
                    'type'=>'file',
                    'label'=>'Photo de profil',
                    'error'=>'Le format du fichier n\'est pas pris en compte.',
                    'part'=>'Information de base',
                    'accept'=>'image/png, image/jpeg',
                ],
                'lastname'=>[
                    'type'=>'text',
                    'min'=>2,
                    'max'=>50,
                    'label'=>'Nom',
                    'required'=>true,
                    'error'=>'Le nom doit faire entre 2 et 50 caractères.'
                ],
                'firstname'=>[
                    'type'=>'text',
                    'min'=>2,
                    'max'=>50,
                    'label'=>'Prénom',
                    'required'=>true,
                    'error'=>'Le prénom doit faire entre 2 et 50 caractères.'
                ],
                'email'=>[
                    'type'=>'email',
                    'min'=>8,
                    'max'=>320,
                    'label' => 'Adresse e-mail',
                    'required'=>true,
                    'error'=>'Veuillez entrer une adresse email valide.',
                ],
                'occupation'=>[
                    'type'=>'text',
                    'max'=>255,
                    'label' => 'Profession',
                    'error'=>'Ce champ doit faire maximum 255 caractères.',
                ],
                'birthday'=>[
                    'type'=>'date',
                    'label'=>'Date de naissance',
                    'error'=>'Le format de la date n\'est pas correct.'
                ],
                'country'=>[
                    'type'=>'select',
                    'label'=>'Zone géographique',
                    'option'=>[['id'=>'', 'name'=>'Tous les pays', 'selected'=>true, 'disabled'=>true], ['id'=>'france', 'name'=>'France'],  ['id'=>'angleterre', 'name'=>'Angleterre'], ['id'=>'etats-unis', 'name'=>'Etats-Unis'], ['id'=>'belgique', 'name'=>'Belgique'], ['id'=>'allemagne', 'name'=>'Allemagne']],
                    'error'=>'Veuillez sélectionner une option valide.'
                ],
                'city'=>[
                    'type'=>'text',
                    'max'=>60,
                    'label'=>'Ville',
                    'error'=>'Votre ville doit faire entre 2 et 60 caractères.',
                    'error'=>' Veuillez sélectionner une option valide.'
                ],
                'website'=>[
                    'type'=>'text',
                    'max'=>2000,
                    'label'=>'Lien vers votre portfolio personnel',
                    'error'=>'Le lien doit faire maximum 2000 caractères.',
                    'part'=>'Sur le web',
                ],
                "link"=>[
                    "type"=>"text",
                    "max"=>255,
                    "label"=>"Lien vers votre compte linkedin",
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
                    "error"=>"ce champ doit faire entre 2 et 255 caractères",
                ],
                "formation"=>[
                    "type"=>"textarea",
                    "min"=>2,
                    "label"=>"Votre parcours académique",
                    "error"=>"ce champ doit faire entre 2 et 255 caractères",
                ],
                "skill"=>[
                    "type"=>"textarea",
                    "min"=>2,
                    "label"=>"Vos compétences",
                    "error"=>"ce champ doit faire entre 2 et 255 caractères",
                ],   
                'interest'=>[
                    'type'=>'textarea',
                    'max'=>1000,
                    'label'=>'Intérêts',
                    'error'=>'Ce champ doit faire maximum 1000 caractères.',
                ],              
            ]
        ];
    }
}
