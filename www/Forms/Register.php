<?php
namespace App\Forms;

class Register
{
    public static function getConfig(): array
    {
        return [
            'config'=>[
                'action'=>'',
                'method'=>'POST',
                'submit'=>'Créer un compte'
            ],
            'inputs'=>[
                'lastname'=>[
                    'type'=>'text',
                    'min'=>2,
                    'max'=>50,
                    'label'=>'Nom',
                    'required'=>true,
                    'error'=>'Votre nom doit faire entre 2 et 50 caractères.'
                ],
                'firstname'=>[
                    'type'=>'text',
                    'min'=>2,
                    'max'=>50,
                    'label'=>'Prénom',
                    'required'=>true,
                    'error'=>'Votre prénom doit faire entre 2 et 50 caractères.'
                ],
                'email'=>[
                    'type'=>'email',
                    'min'=>8,
                    'max'=>320,
                    'label'=>'Adresse e-mail',
                    'required'=>true,
                    'error'=>'Cette adresse e-mail n\'est pas valide.'
                ],
                'password'=>[
                    'type'=>'password',
                    'min'=>8,
                    'max'=>64,
                    'label'=>'Mot de passe',
                    'required'=>true,
                    'error'=>'Votre mot de passe doit faire entre 8 et 64 caractères avec des lettres minscules, majuscules et des chiffres.'
                ],
                'passwordConfirm'=>[
                    'type'=>'password',
                    'min'=>8,
                    'max'=>64,
                    'label'=>'Confirmer le mot de passe',
                    'required'=>true,
                    'confirm'=>'password',
                    'error'=>'La confirmation de votre mot de passe ne correspond pas au mot de passe.'
                ],
            ]
        ];
    }
}