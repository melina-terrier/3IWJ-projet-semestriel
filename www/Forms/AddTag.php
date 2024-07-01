<?php
namespace App\Forms;

class AddTag
{
    public static function getConfig(): array
    {
        return [
            'config'=>[
                'action'=>'',
                'method'=>'POST',
                'submit'=>'Ajouter une catégorie'
            ],
            'inputs'=>[
                'name'=>[
                    'type'=>'text',
                    'min'=>2,
                    'max'=>255,
                    'label'=>'Nom',
                    'required'=>true,
                    'error'=>'Le nom est doit être compris entre 2 et 255 caractères.'
                ],
                'slug'=>[
                    'type'=>'text',
                    'max'=>255,
                    'label'=>'Slug',
                    'error'=>'Le slug doit avoir au maximum 255 caractères.'
                ],
                'description'=>[
                    'type'=>'textarea',
                    'max'=>1000,
                    'label'=>'Description',
                    'error'=>'La description doit avoir au maximum 1000 caractères.'
                ]
            ]
        ];
    }
}