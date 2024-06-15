<?php
namespace App\Forms;

use App\Models\PageHistory;
class AddPage
{
    public static function getConfig(): array
    {

        $history = new PageHistory();
        $histories = $history->getAllDataWithWhere(['page_id'=>$_GET['id']], 'object');

        $historyPage = [];
        if (!empty($histories)) {
            foreach ($histories as $page) {
              $historyPage[] = [
                "id" => $page->getId(),
                "name" => $page->getCreationDate(),
              ];
            }
        } else {
            $historyPage[] = [
                "id" => '',
                "name" => '',
                "selected" => true,
            ];
        }

        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Publier"
            ],
            "inputs"=>[
                "title"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>1000,
                    "label"=>"Titre de la page",
                    "required"=>true,
                    "error"=>"Le titre de la page doit faire entre 2 et 1000 caractères",
                ],
                "content"=>[
                    "type"=>"textarea",
                    "id"=>"content",
                    "label"=>"Contenu",
                    "min"=>2,
                    "error"=>"Le contenu est requis et doit avoir au minimum 2 caractères",
                ],
                "slug"=>[
                    "type"=>"text",
                    "label"=>"Slug",
                    "max"=>255,
                    "error"=>"Le slug doit avoir au moins 255 caractères."
                ],
                "history"=>[
                    "type"=>"select",
                    "name"=>"history",
                    "label"=>"Ancienne version de la page",
                    "option"=>$historyPage, 
                ],
            ]
        ];
    }

}