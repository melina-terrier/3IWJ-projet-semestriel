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
        $status = $statusModel->getOneBy(["status"=>"Publié"], 'object');
        $statusId = $status->getId();
        $pages = $page->getAllDataWithWhere(["status_id"=>$statusId], 'object');
        $formattedPages = [];
        $formattedPages[] = ["id"=>"Projects", "name"=>"Tous les projets"];
        $formattedPages[] = ["id"=>"Users", "name"=>"Tous les utilisateurs"];
        if (!empty($pages)) {
            foreach ($pages as $page) {
                $formattedPages[] = [
                    "id" => $page->getId(),
                    "name" => $page->getTitle(),
                ];
            }
        }
        $tag = new TagModel();
        $tags = $tag->getAllData('object');
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                $formattedPages[] = [
                    "id" => $tag->getId(),
                    "name" => $tag->getName(),
                ];
            }
        }

        $timezones = \DateTimeZone::listIdentifiers();
        $timezone = [];
        $timezone[] = ["id"=>"défaut", "name"=>"Défaut"];
        if (!empty($timezones)) {
        foreach ($timezones as $singleTimezone) {
            $timezone[] = [
            "id" => strtolower($singleTimezone),
            "name" => $singleTimezone,
            ];
        }
        } else {
        $timezone[] = [
            "id" => '0',
            "name" => 'Aucune timezone',
            "selected" => true,
        ];
        }

        return [
            "config" => [
                "action" => "",
                "method" => "POST",
                "submit" => "Enregistrer"
            ],
            "inputs" => [
                "menu" => [
                    "type" => "custom",
                    "label" => "Menu",
                    "option"=>$formattedPages,
                    "error" => ""
                ],
                "type" => [
                    "type" => "select",
                    "label" => "Type du menu",
                    "option"=> [['id'=>'menu-principal', 'name'=>'Menu principal'], ['id'=>'footer', 'name'=>'footer']],
                    "error" => ""
                ],

            ]
        ];
    }
}