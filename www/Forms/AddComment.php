<?php

namespace App\Forms;

class AddComment
{

    public static function getConfig(): array
    {
        $config = [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Publier"
            ],
            "inputs"=>[]
        ];
        if (isset($_SESSION['user'])) {
            $config["inputs"]["comment"] = [
                "type"=>"textarea",
                "min"=>2,
                "max"=>4000,
                "label"=>"Laisser un commentaire",
                "required"=>true,
                "error"=>"Votre commentaire doit faire entre 2 et 4000 caractères"
            ];
        } else {
            $config["inputs"]["comment"] = [
                "type"=>"textarea",
                "min"=>2,
                "max"=>4000,
                "label"=>"Laisser un commentaire",
                "required"=>true,
                "error"=>"Votre commentaire doit faire entre 2 et 4000 caractères"
            ];
            $config["inputs"]["email"] = [
                "type"=>"email",
                "min"=>8,
                "max"=>320,
                "label"=>"Email",
                "required"=>true,
                "error"=>"Le format de l'email est incorrect"
            ];
            $config["inputs"]["name"] = [
                "type"=>"text",
                "min"=>4,
                "max"=>100,
                "label"=>"Nom et prénom",
                "required"=>true,
                "error"=>"Le nom et le prénom doivent faire entre 4 et 100 caractères"
            ];
        }
        return $config;
    }

}