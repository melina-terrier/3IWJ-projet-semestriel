<?php
namespace App\Forms;
use App\Models\Page as PageModel;
use App\Models\Tag as TagModel;
use App\Models\Status as StatusModel;

class SetMenu
{
    public static function getConfig(): array
    {
        $page = new PageModel();
        $statusModel = new StatusModel();
        $status = $statusModel->getOneBy(['status'=>'Publié'], 'object');
        $statusId = $status->getId();
        $pages = $page->getAllData(['status_id'=>$statusId], null, 'object');
        $formattedPages = [];
        $formattedPages[] = ['id'=>'Projects', 'name'=>'Tous les projets', 'url'=>'/projects'];
        $formattedPages[] = ['id'=>'Users', 'name'=>'Tous les utilisateurs', 'url'=>'/profiles'];
        if (!empty($pages)) {
            foreach ($pages as $page) {
                $formattedPages[] = [
                    'id' => $page->getId(),
                    'name' => $page->getTitle(),
                    'url' => $page->getSlug(),
                ];
            }
        }

        return [
            'config' => [
                'action' => '',
                'method' => 'POST',
                'submit' => 'Enregistrer'
            ],
            'inputs' => [
                'type' => [
                    'type' => 'select',
                    'label' => 'Type du menu',
                    'option'=> [
                        ['id'=>'menu-principal', 'name'=>'Menu principal'], 
                        ['id'=>'footer', 'name'=>'footer']
                    ],
                    'error' => 'Veuillez sélectionner une option valide.',
                    'required'=>true,
                ],
                'position' => [
                    'type' => 'select',
                    'label' => 'Position du menu',
                    'required'=>true,
                    'option'=> [
                        ['id'=>'vertical', 'name'=>'Menu vertical'], 
                        ['id'=>'horizontal', 'name'=>'Menu horizontal'], 
                        ['id'=>'burger', 'name'=>'Menu hamburger']
                    ],
                    'error'=>' Veuillez sélectionner une option valide.'
                ],
                'vertical-alignement'=> [
                    'type' => 'select',
                    'label' => 'Alignement du menu',
                    'option'=> [
                        ['id'=>'right', 'name'=>'A droite'], 
                        ['id'=>'left', 'name'=>'A gauche']
                    ],
                    'depends-to' => 'vertical, burger',
                    'error'=>' Veuillez sélectionner une option valide.'
                ],
                'horizontal-alignement' => [
                    'type' => 'select',
                    'option'=> [
                        ['id'=>'center', 'name'=>'Centrer'], 
                        ['id'=>'right', 'name'=>'A droite'], 
                        ['id'=>'left', 'name'=>'A gauche'], 
                        ['id'=>'justify', 'name'=>'Justifié']
                    ],
                    'depends-to' => 'horizontal',
                    'error'=>' Veuillez sélectionner une option valide.'
                ],
                'page-list' => [
                    'type' => 'checkbox',
                    'label' => 'Liste des pages',
                    'option'=>$formattedPages,
                    'part' => 'Pages du site',
                    'error'=>'Veuillez sélectionner une option valide.'
                ],
                'menu' => [
                    'type' => 'custom',
                    'label' => 'Menu',
                    'required'=>true,
                ]
            ]
        ];
    }
}