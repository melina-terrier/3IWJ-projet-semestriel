<?php
namespace App\Forms;

class EditMedia
{
    public static function getConfig(): array
    {
        return [
            'config'=>[
                'action'=>'',
                'method'=>'POST',
                'submit'=>'Enregistrer un média',
                'enctype'=>'multipart/form-data',
            ],
            'inputs'=>[
                'title'=>[
                    'type'=>'text',
                    'min'=>2,
                    'max'=>255,
                    'label'=>'Titre',
                    'required'=>true,
                    'error'=>'Le titre est requis et doit faire entre 2 et 255 caractères.'
                ],
                'description'=>[
                    'type'=>'textarea',
                    'min'=>2,
                    'max'=>1000,
                    'label'=>'Description',
                    'required'=>true,
                    'error'=>'La description est requise et doit faire entre 2 et 1000 caractères.',
                ]
            ]
        ];
    }
}