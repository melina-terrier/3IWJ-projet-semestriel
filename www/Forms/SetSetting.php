<?php
namespace App\Forms;
use App\Models\Page as PageModel;
use App\Models\Tag as TagModel;
use App\Models\Status as StatusModel;
use App\Models\Media;

class SetSetting
{
    public static function getConfig(): array
    {
        $page = new PageModel();
        $statusModel = new StatusModel();
        $status = $statusModel->getOneBy(['status'=>'Publié'], 'object');
        $statusId = $status->getId();
        $pages = $page->getAllData(['status_id'=>$statusId], null, 'object');
        $formattedPages = [];
        $formattedPages[] = ['id'=>'', 'name'=>'Page par défaut', 'selected'=>true];
        $formattedPages[] = ['id'=>'Projects', 'name'=>'Tous les projets'];
        $formattedPages[] = ['id'=>'Users', 'name'=>'Tous les utilisateurs'];
        if (!empty($pages)) {
            foreach ($pages as $page) {
                $formattedPages[] = [
                    'id' => $page->getId(),
                    'name' => $page->getTitle(),
                ];
            }
        }
        $tag = new TagModel();
        $tags = $tag->getAllData(null, null, 'object');
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                $formattedPages[] = [
                    'id' => $tag->getId(),
                    'name' => $tag->getName(),
                ];
            }
        }

        $timezones = \DateTimeZone::listIdentifiers();
        $timezone = [];
        $timezone[] = ['id'=>'défaut', 'name'=>'Défaut', 'selected'=>true, 'disabled'=>true];
        if (!empty($timezones)) {
            foreach ($timezones as $singleTimezone) {
                $timezone[] = [
                'id' => strtolower($singleTimezone),
                'name' => $singleTimezone,
                ];
            }
        }

        $media = new Media();
        $medias = $media->getAllData(null, null, 'object');
        $arrayMedias = [];
        if (!empty($medias)) {
            foreach ($medias as $mediaObject) {
              $arrayMedias[] = [
                'id' => $mediaObject->getUrl(),
                'name' => $mediaObject->getName(),
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
                'title' => [
                    'type' => 'text',
                    'min' => 2,
                    'max' => 255,
                    'label' => 'Titre du site',
                    'required' => true,
                    'error' => 'Le nom du site doit faire entre 2 et 255 caractères.',
                    'part' => 'Information du site web'
                ],
                'logo' => [
                    'type' => 'media',
                    'label' => 'Logo du site',
                    'option'=>$arrayMedias,
                    'error'=>'Veuillez sélectionner une option valide.'
                ],
                'slogan' => [
                    'type' => 'text',
                    'max' => 500,
                    'label' => 'Slogan',
                    'error' => 'Le slogan doit faire au maximum 500 caractères.'
                ],
                'site_description' => [
                    'type' => 'text',
                    'max'=>1000,
                    'label' => 'Description du site',
                    'error' => 'La description du site doit faire au maximum 1000 caractères.'
                ],
                'timezone' => [
                    'type' => 'select',
                    'label' => 'Fuseau horaire',
                    'option' => $timezone,
                    'error'=>' Veuillez sélectionner une option valide.'
                ], 
                'homepage' => [
                    'type' => 'select',
                    'label' => 'Page d\'accueil',
                    'option' => $formattedPages,
                    'error'=>' Veuillez sélectionner une option valide.'
                ],
                'comment' => [
                    'type' => 'radio',
                    'label' => 'Autoriser les commentaires',
                    'required'=>true,
                    'option' => [['id'=>'true', 'name'=>'Activer', 'checked'=>true], ['id'=>'false', 'name'=>'Désactiver']],
                    'error'=>' Veuillez sélectionner au moins une option.'
                ],
            ]
        ];
    }
}