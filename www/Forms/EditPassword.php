<?php

namespace App\Forms;

class EditPassword
{
    public static function getConfig(): array
    {
        return [
            'config'=> [
                'action'=>'',
                'method'=>'POST',
                'submit'=>'Changer le mot de passe',
            ],
            'inputs'=>[
                'old-password'=>[
                    'type'=>'password',
                    'min'=>8,
                    'max'=>64,
                    'label'=>'Mot de passe actuel',
                    'required'=>true,
                    'error'=>'Votre mot de passe doit faire entre 8 et 64 caractères avec des lettres minscules, majuscules et des chiffres.'
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
                    'error'=>'La confirmation de votre mot de passe ne correspond pas au mot de passe.',
                    'confirm'=>'password',
                ],
            ]
        ];
    }


}
