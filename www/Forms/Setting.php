<?php
namespace App\Forms;

class Setting
{
    public static function getConfig(): array
    {
        return [
            "config" => [
                "action" => "",
                "method" => "POST",
                "submit" => "Enregistrer"
            ],
            "inputs" => [
                "icon" => [
                    "type" => "file",
                    "label" => "Icône du site ",
                    "required" => true,
                    "error" => ""
                ],
                "title" => [
                    "type" => "text",
                    "min" => 2,
                    "max" => 50,
                    "label" => "Titre du site",
                    "required" => true,
                    "error" => ""
                ],
                "description" => [
                    "type" => "textarea",
                    "min" => 2,
                    "max" => 255,
                    "label" => "Description du site",
                    "required" => true,
                    "error" => ""
                ],
                "logo" => [
                    "type" => "file",
                    "label" => "Création de logo",
                    "required" => false,
                    "error" => ""
                ],
             /*   "language" => [
                    "type" => "select",
                    "label" => "Choisir la Langue",
                    "option" => [
                        ["name" => "francais", "id" => "1"],
                        ["name" => "anglais", "id" => "2"],
                        ["name" => "espagnol", "id" => "3"]
                    ],
                    "required" => true,
                    "error" => ""
                ],
                "timezone" => [
                    "type" => "select",
                    "label" => "choisir le Fuseau horaire",
                    "options" => \DateTimeZone::listIdentifiers(), // Liste des fuseaux horaires disponibles
                    "required" => true,
                    "error" => ""
                ]*/
            ]
        ];
    }
}
