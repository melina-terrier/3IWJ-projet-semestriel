<?php
namespace App\Forms;
use App\Models\Page as PageModel;
use App\Models\Tag as TagModel;
use App\Models\Status as StatusModel;

class SetAppearance
{
    public static function getConfig(): array
    {
        return [
            'config' => [
                'action' => '',
                'method' => 'POST',
                'submit' => 'Enregistrer'
            ],
            'inputs' => [
                'light-primary_color' => [
                    'type' => 'color',
                    'label' => 'Couleur principale',
                    'part' => 'Couleur du mode claire',
                    'error' => 'La couleur doit être au format hexadecimal.'
                ],
                'light-secondary_color' => [
                    'type' => 'color',
                    'label' => 'Couleur secondaire',
                    'error' => 'La couleur doit être au format hexadecimal.'
                ],
                'light-accent_color' => [
                    'type' => 'color',
                    'label' => 'Couleur d\'accentuation',
                    'error' => 'La couleur doit être au format hexadecimal.'
                ],
                'dark-primary_color' => [
                    'type' => 'color',
                    'label' => 'Couleur principale',
                    'part' => 'Couleur du mode sombre',
                    'error' => 'La couleur doit être au format hexadecimal.'
                ],
                'dark-secondary_color' => [
                    'type' => 'color',
                    'label' => 'Couleur secondaire',
                    'error' => 'La couleur doit être au format hexadecimal.'
                ],
                'dark-accent_color' => [
                    'type' => 'color',
                    'label' => 'Couleur d\'accentuation',
                    'error' => 'La couleur doit être au format hexadecimal.'
                ],
                'primary_font' => [
                    'type' => 'select',
                    'label' => 'Police des titres',
                    'option' => [
                        ['id'=>'', 'name'=>'Sélectionnez une police d\'ecriture', 'selected'=>true, 'disabled'=>true],
                        ['id'=>'roboto', 'name'=>'Roboto'], 
                        ['id'=>'open-sans', 'name'=>'Open Sans'],
                        ['id'=>'montserrat', 'name'=>'Montserrat'],
                        ['id'=>'lato', 'name'=>'Lato'],
                        ['id'=>'noto-sans', 'name'=>'Noto Sans']
                    ],
                    'error' => 'Veuillez sélectionner une option valide.'
                ], 
                'secundary_font' => [
                    'type' => 'select',
                    'label' => 'Police du texte',
                    'option' => [
                        ['id'=>'', 'name'=>'Sélectionnez une police d\'ecriture', 'selected'=>true, 'disabled'=>true],
                        ['id'=>'roboto', 'name'=>'Roboto'], 
                        ['id'=>'open-sans', 'name'=>'Open Sans'],
                        ['id'=>'montserrat', 'name'=>'Montserrat'],
                        ['id'=>'lato', 'name'=>'Lato'],
                        ['id'=>'noto-sans', 'name'=>'Noto Sans']
                    ],
                    'error' => 'Veuillez sélectionner une option valide.'
                ], 
            ]
        ];
    }
}