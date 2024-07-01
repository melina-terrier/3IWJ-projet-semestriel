<?php
namespace App\Forms;
use App\Models\Tag;
use App\Models\Media;
use App\Core\Form;

class AddProject
{
    public static function getConfig(): array
    {
        $tag = new Tag();
        $tags = $tag->getAllData(null, null, 'object');
        $formattedTags = [];
        $formattedTags[] = ['id'=>'', 'name'=>'Sélectionnez une catégorie', 'disabled'=>true, 'selected'=>true];
        if (!empty($tags)) {
            foreach ($tags as $tagObject) {
              $formattedTags[] = [
                'id' => $tagObject->getId(),
                'name' => $tagObject->getName(),
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
            'config'=>[
                'action'=>'',
                'method'=>'POST',
                'submit'=>'Publier',
            ],
            'inputs'=>[
                'title'=>[
                    'type'=>'text',
                    'min'=>2,
                    'max'=>255,
                    'label'=>'Titre du projet',
                    'required'=>true,
                    'error'=>'Votre titre doit faire entre 2 et 255 caractères.'
                ],
                'content'=>[
                    'type'=>'textarea',
                    'min'=>2,
                    'label'=>'Contenu',
                    'required'=>true,
                    'error'=>'Le contenu doit avoir au minimum 2 caractères.',
                    'id'=>'content',
                ],
                'featured_image'=>[
                    'type'=>'media',
                    'label'=>'Image mise en avant',
                    'option'=>$arrayMedias,
                    'error' => 'Veuillez sélectionner une option valide.'
                ],
                'slug'=>[
                    'type'=>'text',
                    'max'=>255,
                    'label'=>'Slug',
                    'error' => 'Le slug doit avoir au maximum 255 caractères.'
                ],
                'tag'=>[
                    'type'=>'select',
                    'label'=>'Catégorie du projet',
                    'option'=>$formattedTags, 
                    'multiple'=>true,
                    'name'=>'tag[]',
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
            ],
        ];
    }
}
