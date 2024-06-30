<?php
namespace App\Forms;

use App\Models\Role as RoleModel;

class AddUser
{
    public static function getConfig(): array
    {

        $role = new RoleModel();
        $roles = $role->getAllData('object');

        $formattedRoles = [];
        if (!empty($roles)) {
            foreach ($roles as $role) {
              $formattedRoles[] = [
                "id" => $role->getId(),
                "name" => $role->getName(),
              ];
            }
        } else {
            $formattedRoles[] = [
                "id" => '0',
                "name" => 'Aucun rôle disponible',
                "selected" => true,
              ];
        }

        return [
            "config"=>[
                "action"=>"",
                "method"=>"POST",
                "submit"=>"Envoyer un mail de création de mot de passe"
                ],
            "inputs"=>[
                "lastname"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Nom",
                    "required"=>true,
                    "error"=>"Le nom doit faire entre 2 et 50 caractères"
                ],
                "firstname"=>[
                    "type"=>"text",
                    "min"=>2,
                    "max"=>50,
                    "label"=>"Prénom",
                    "required"=>true,
                    "error"=>"Le prénom doit faire entre 2 et 50 caractères"
                ],
                "email"=>[
                    "type"=>"email",
                    "min"=>8,
                    "max"=>320,
                    "label"=>"Email",
                    "required"=>true,
                    "error"=>"L'email doit faire entre 8 et 320 caractères"
                ],
                 "role"=>[
                    "type"=>"select",
                    "label"=>"Rôle",
                    "required"=>true,
                    "option"=>$formattedRoles, 
                    "error"=>"Veuillez sélectionner un rôle"
                ],
            ]

        ];
    }
}