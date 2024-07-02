<?php
namespace App\Forms;

class Login
{
    public static function getConfig(): array
    {
        return [
            'config'=>[
                'action'=>'',
                'method'=>'POST',
                'submit'=>'Se connecter'
            ],
            'inputs'=>[
                'email'=>[
                    'type'=>'email',
                    'min'=>8,
                    'max'=>320,
                    'label'=>'Adresse e-mail',
                    'required'=>true,
                    'error'=>'Le format de l\'adresse e-mail est incorrect.'
                ],
                'password'=>[
                    'type'=>'password',
                    'min'=>8,
                    'max'=>64,
                    'label'=>'Mot de passe',
                    'required'=>true,
                    'error'=>'Le mot de passe doit faire entre 8 et 64 caractères.'
                ]
            ]
        ];
    }
}