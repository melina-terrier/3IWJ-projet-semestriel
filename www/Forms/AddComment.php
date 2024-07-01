<?php

namespace App\Forms;

class AddComment
{
    public static function getConfig(): array
    {
        $config = [
            'config'=>[
                'action'=>'',
                'method'=>'POST',
                'submit'=>'Publier'
            ],
            'inputs'=>[
                'comment' => [
                    'type'=>'textarea',
                    'min'=>2,
                    'max'=>1000,
                    'label'=>'Laisser un commentaire',
                    'required'=>true,
                    'error'=>'Votre commentaire doit faire entre 2 et 1000 caractères.'
                ]
            ]
        ];
        
        if (!isset($_SESSION['user'])) {
            $config['inputs']['email'] = [
                'type'=>'email',
                'min'=>8,
                'max'=>320,
                'label'=>'Adresse e-mail',
                'required'=>true,
                'error'=>'Le format de l\'email est incorrect.'
            ];
            $config['inputs']['name'] = [
                'type'=>'text',
                'min'=>4,
                'max'=>110,
                'label'=>'Nom et prénom',
                'required'=>true,
                'error'=>'Le nom et le prénom doivent faire entre 4 et 110 caractères.'
            ];
        }
        return $config;
    }

}