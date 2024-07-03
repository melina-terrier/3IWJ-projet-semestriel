<?php
namespace App\Forms;
use App\Models\PageHistory;

class AddPage
{
    public static function getConfig(): array
    {
        $history = new PageHistory();
        if (isset($_GET['id'])){
            $histories = $history->getAllData(['page_id'=>$_GET['id']], null, 'array');
        }
        $historyPage = [];
        $historyPage[] = ['id'=>'', 'name'=>'Sélectionnez une version', 'disabled'=>true, 'selected'=>true];
        if (!empty($histories)) {
            foreach ($histories as $page) {
              $historyPage[] = [
                'id' => $page['id'],
                'name' => $page['creation_date'],
              ];
            }
        }

        return [
            'config'=>[
                'action'=>'',
                'method'=>'POST',
                'submit'=>'Publier'
            ],
            'inputs'=>[
                'title'=>[
                    'type'=>'text',
                    'min'=>2,
                    'max'=>255,
                    'label'=>'Titre de la page',
                    'required'=>true,
                    'error'=>'Le titre de la page doit faire entre 2 et 255 caractères.',
                ],
                'content'=>[
                    'type'=>'textarea',
                    'min'=>2,
                    'label'=>'Contenu',
                    'error'=>'Le contenu doit avoir au minimum 2 caractères.',
                    'id'=>'content',
                ],
                'slug'=>[
                    'type'=>'text',
                    'max'=>255,
                    'label'=>'Slug',
                    'error'=>'Le slug doit avoir au maximum 255 caractères.'
                ],
                'history'=>[
                    'type'=>'select',
                    'label'=>'Restaurer une ancienne version de la page pour la restaurer.',
                    'option'=>$historyPage, 
                    'error' => 'Veuillez sélectionner une option valide.'
                ],
                'seo_title'=>[
                    'type'=>'text',
                    'max'=>255,
                    'label'=>'Titre SEO',
                    'error'=>'Le titre doit faire entre 2 et 255 caractères.',
                    'part'=>'SEO',
                ],
                'seo_keyword'=>[
                    'type'=>'text',
                    'max'=>100,
                    'label'=>'Mot clé (séparés par des virgules)',
                    'error'=>'Les mots clés doivent faire au maximum 100 caractères.'
                ],
                'seo_description'=>[
                    'type'=>'textarea',
                    'max'=>255,
                    'label'=>'Méta description',
                    'error'=>'La description doit faire entre 2 et 255 caractères.'
                ],
                'submit-draft'=>[
                    'type'=>'submit',
                    'label'=>'Enregistrer le brouillon',
                    'value'=>'Sauvegarder', 
                ],
            ]
        ];
    }

}