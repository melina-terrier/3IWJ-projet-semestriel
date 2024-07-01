<?php
namespace App\Forms;

class AddMedia
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
                'media'=>[
                    'type'=>'file',
                    'label'=>'Média',
                    'required'=>true,
                    'error'=>'Le format du fichier n\'est pas pris en compte.',
                    'accept'=>'image/png, image/jpeg, application/pdf, image/svg'
                ],
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
                    'error'=>'La description est requise et doit faire entre 2 et 1000 caractères.'
                ]
            ]
        ];
    }
}