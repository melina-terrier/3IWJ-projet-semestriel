<?php
namespace App\Forms;

class ResetPassword
{
    public static function getConfig(): array
    {
        return [
            'config'=>[
                'action'=>'',
                'method'=>'POST',
                'submit'=>'Changer le mot de passe'
            ],
            'inputs'=>[
                'token'=>[
                    'type'=>'hidden', 
                ],
                'password'=>[
                    'type'=>'password',
                    'min'=>8,
                    'max'=>64,
                    'label'=>'Nouveau mot de passe',
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
                    'error'=>'Votre mot de passe ne correspond pas.'
                ], 
            ]
        ];
    }
}