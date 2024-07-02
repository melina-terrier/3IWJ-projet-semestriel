<?php
namespace App\Forms;

class RequestPassword
{
    public static function getConfig(): array
    {
        return [
            'config'=>[
                'action'=>'',
                'method'=>'POST',
                'submit'=>'Recevoir le lien de réinitialisation'
            ],
            'inputs'=>[
                'email'=>[
                    'type'=>'email',
                    'min'=>8,
                    'max'=>320,
                    'label'=>'Adresse e-mail',
                    'required'=>true,
                    'error'=>'Le format de l\'adresse e-mail est incorrect.'
                ]
            ]
        ];
    }
}